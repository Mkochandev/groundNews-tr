<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Source;
use App\Models\Article;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class FetchNews extends Command
{
    protected $signature = 'news:fetch'; // Komutun adı
    protected $description = 'Tüm kaynaklardan son haberleri çeker';

    public function handle()
    {
        $sources = Source::all();
        $this->info($sources->count() . " kaynak taranıyor...");

        foreach ($sources as $source) {
            $this->line("📡 {$source->name} taranıyor...");

            try {
                // 1. RSS Verisini Çek (User-Agent ekliyoruz ki bot sanıp engellemesinler)
                $response = Http::timeout(10)->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
                ])->get($source->rss_url);

                // 2. XML Hata Yönetimini Etkinleştir
                libxml_use_internal_errors(true);
                libxml_clear_errors();

                // 3. XML içeriğini al ve encoding sorunlarını düzelt
                $xmlContent = (string) $response;

                // UTF-8 encoding sorunlarını düzelt
                if (!mb_check_encoding($xmlContent, 'UTF-8')) {
                    $xmlContent = mb_convert_encoding($xmlContent, 'UTF-8', mb_detect_encoding($xmlContent));
                }

                // Bazı yaygın HTML hatalarını düzelt
                $xmlContent = preg_replace('/<([^>]+)\s+(crossorigin|async|defer)(?!=)/', '<$1 $2=""', $xmlContent);

                // 4. XML Verisini Parçala (LIBXML_NOERROR ile hataları atla)
                $rss = simplexml_load_string(
                    $xmlContent,
                    'SimpleXMLElement',
                    LIBXML_NOERROR | LIBXML_NOWARNING | LIBXML_NOCDATA
                );

                // XML hatalarını kontrol et ama sadece kritik hataları göster
                $errors = libxml_get_errors();
                if (!empty($errors)) {
                    $this->warn("⚠️ {$source->name}: " . count($errors) . " XML uyarısı (göz ardı edildi)");
                    libxml_clear_errors();
                }

                if (!$rss) {
                    $this->error("❌ {$source->name} RSS formatı bozuk.");
                    continue;
                }

                // GÜVENLİK KONTROLÜ:
                if (!isset($rss->channel->item) && !isset($rss->item)) {
                    $this->error("❌ {$source->name} RSS içeriği boş veya formatı farklı.");
                    continue;
                }

                // RSS 1.0 ve RSS 2.0 formatlarını destekle
                $items = isset($rss->channel->item) ? $rss->channel->item : $rss->item;

                $count = 0;
                $processedCount = 0;
                $maxPerSource = (int) env('NEWS_FETCH_LIMIT_PER_SOURCE', 100);

                // 5. Haberleri Döngüye Al
                foreach ($items as $item) {
                    // Kaynak başına limit kontrolü
                    if ($processedCount >= $maxPerSource) {
                        $this->warn("⚠️ {$source->name}: Limit aşıldı (max {$maxPerSource} haber)");
                        break;
                    }

                    // Sadece son 24 saatteki haberleri al
                    $pubDate = Carbon::parse((string) $item->pubDate);

                    if ($pubDate->diffInHours(now()) > 24)
                        continue;

                    $processedCount++;

                    // Extract image URL from RSS item
                    $imageUrl = $this->extractImageFromItem($item, (string) $item->link);

                    // 4. Veritabanına Kaydet veya Güncelle
                    $article = Article::firstOrNew(['url' => (string) $item->link]);

                    $article->source_id = $source->id;
                    $article->title = (string) $item->title;
                    $article->description = strip_tags((string) $item->description);
                    $article->published_at = $pubDate;

                    // Eğer resim bulduysak, validasyon yap ve indir
                    if ($imageUrl) {
                        $localImagePath = $this->downloadAndSaveImage($imageUrl, $article->id ?? uniqid());
                        if ($localImagePath) {
                            $article->image_url = $localImagePath;
                        }
                    }

                    $article->save();

                    if ($article->wasRecentlyCreated) {
                        $count++;
                    }

                    // Progress indicator for large feeds
                    if ($processedCount % 50 === 0) {
                        $this->line("   → {$processedCount} haber işlendi...");
                    }
                }

                $this->info("✅ {$source->name}: {$count} yeni haber eklendi.");

            } catch (\Exception $e) {
                $this->error("⚠️ Hata ({$source->name}): " . $e->getMessage());
            }
        }

        $this->info("🚀 Tüm tarama tamamlandı!");
    }

    /**
     * Extract image URL from RSS item
     * Priority: media:content > enclosure > description img > og:image meta tag
     */
    private function extractImageFromItem($item, $articleUrl)
    {
        // 1. Check for media:content tag (common in RSS 2.0 feeds)
        $media = $item->children('http://search.yahoo.com/mrss/');
        if (isset($media->content)) {
            $attributes = $media->content->attributes();
            if (isset($attributes['url'])) {
                return (string) $attributes['url'];
            }
        }

        // Check for media:thumbnail
        if (isset($media->thumbnail)) {
            $attributes = $media->thumbnail->attributes();
            if (isset($attributes['url'])) {
                return (string) $attributes['url'];
            }
        }

        // 2. Check for enclosure tag (common for images)
        if (isset($item->enclosure)) {
            $attributes = $item->enclosure->attributes();
            if (isset($attributes['type']) && isset($attributes['url'])) {
                $type = (string) $attributes['type'];
                if (strpos($type, 'image/') === 0) {
                    return (string) $attributes['url'];
                }
            }
        }

        // 3. Extract first <img> from description
        $description = (string) $item->description;
        if (preg_match('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $description, $matches)) {
            return $matches[1];
        }

        // 4. Fallback: Try to get og:image from article page (expensive, use sparingly)
        try {
            $response = Http::timeout(5)->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
            ])->get($articleUrl);

            if ($response->successful()) {
                $html = (string) $response;
                // Look for og:image meta tag
                if (preg_match('/<meta[^>]+property=["\']og:image["\'][^>]+content=["\']([^"\']+)["\'][^>]*>/i', $html, $matches)) {
                    return $matches[1];
                }
                // Alternative format
                if (preg_match('/<meta[^>]+content=["\']([^"\']+)["\'][^>]+property=["\']og:image["\'][^>]*>/i', $html, $matches)) {
                    return $matches[1];
                }
            }
        } catch (\Exception $e) {
            // Silently fail on meta tag extraction - not critical
        }

        return null;
    }

    /**
     * Validate image URL - check if accessible and meets quality standards
     * @param string $url
     * @return array|null Returns ['url' => $url, 'width' => $w, 'height' => $h] or null
     */
    private function validateImageUrl($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }

        try {
            // Try HEAD request first to check headers without downloading
            $response = Http::timeout(5)->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'
            ])->head($url);

            if (!$response->successful()) {
                return null;
            }

            // Check Content-Type
            $contentType = $response->header('Content-Type');
            if (!$contentType || strpos($contentType, 'image/') !== 0) {
                return null;
            }

            // Check file size (if provided in headers)
            $contentLength = $response->header('Content-Length');
            $maxSize = (int) (env('IMAGE_MAX_SIZE', 5120) * 1024); // Convert KB to bytes
            if ($contentLength && $contentLength > $maxSize) {
                return null;
            }

            // Get image dimensions (requires downloading the image)
            $imageData = Http::timeout(10)->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'
            ])->get($url);

            if (!$imageData->successful()) {
                return null;
            }

            // Save to temp file to check dimensions
            $tempFile = tempnam(sys_get_temp_dir(), 'img_');
            file_put_contents($tempFile, $imageData->body());

            $imageInfo = @getimagesize($tempFile);
            unlink($tempFile);

            if (!$imageInfo) {
                return null;
            }

            [$width, $height] = $imageInfo;
            $minWidth = (int) env('IMAGE_MIN_WIDTH', 200);
            $minHeight = (int) env('IMAGE_MIN_HEIGHT', 200);

            if ($width < $minWidth || $height < $minHeight) {
                return null;
            }

            return [
                'url' => $url,
                'width' => $width,
                'height' => $height,
                'data' => $imageData->body() // Return image data to avoid re-downloading
            ];

        } catch (\Exception $e) {
            // Silently fail
            return null;
        }
    }

    /**
     * Download image and save to local storage
     * @param string $url
     * @param int|string $articleId
     * @return string|null Returns local path or null on failure
     */
    private function downloadAndSaveImage($url, $articleId)
    {
        if (!env('IMAGE_DOWNLOAD_ENABLED', true)) {
            return $url; // Return original URL if download disabled
        }

        // Validate image first
        $validatedImage = $this->validateImageUrl($url);
        if (!$validatedImage) {
            return null;
        }

        try {
            // Generate unique filename
            $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
            if (!$extension || strlen($extension) > 5) {
                $extension = 'jpg'; // Fallback
            }

            $hash = substr(md5($url), 0, 8);
            $filename = "article_{$articleId}_{$hash}.{$extension}";
            $path = "news-images/{$filename}";

            // Save to storage/app/public/news-images/
            Storage::disk('public')->put($path, $validatedImage['data']);

            // Return public URL path
            return "/storage/{$path}";

        } catch (\Exception $e) {
            $this->warn("⚠️ Resim indirilemedi: {$url} - " . $e->getMessage());
            return null;
        }
    }
}