<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Article;
use App\Models\NewsCluster;
use App\Services\GeminiAnalystService;
use Illuminate\Support\Facades\Http;

class ClusterNews extends Command
{
    protected $signature = 'news:cluster';
    protected $description = 'Haberleri gruplandırır';

    public function handle(GeminiAnalystService $gemini)
    {
        $this->info("Kümeleme taraması başlatılıyor...");

        // Kümelenmemiş haberleri al (CLUSTER_LIMIT kadar - API quota için)
        $clusterLimit = (int) env('CLUSTER_LIMIT', 50);
        $articles = Article::whereNull('news_cluster_id')
            ->orderBy('id', 'desc')
            ->take($clusterLimit)
            ->get();

        if ($articles->isEmpty()) {
            $this->info("Kümelenmemiş haber bulunamadı.");
            return;
        }

        $this->info($articles->count() . " haber analiz ediliyor...");

        // Servisi çağır
        $clusters = $gemini->clusterNews($articles);

        // ÖNEMLİ: İşlem gören TÜM haberleri "analiz edildi" olarak işaretle.
        // Böylece kümelemeye girmeyen haberler tekrar tekrar Gemini'ye gönderilmez.
        $articleIds = $articles->pluck('id')->toArray();
        Article::whereIn('id', $articleIds)->update(['is_analyzed' => true]);

        if (empty($clusters)) {
            $this->info("Eşleşen haber grubu bulunamadı veya API yanıt vermedi.");
            return;
        }

        $createdCount = 0;
        $updatedCount = 0;

        foreach ($clusters as $group) {
            // ÖNEMLİ KURAL: Eğer grupta 2'den az haber varsa, kümeleme yapma.
            if (!isset($group['article_ids']) || count($group['article_ids']) < 2) {
                continue;
            }

            // Get cluster articles with source info
            $clusterArticles = Article::whereIn('id', $group['article_ids'])->with('source')->get();

            // DUPLİKAT KONTROLÜ: Aynı article'ın birden fazla kez gelmesini engelle
            $uniqueArticleIds = $clusterArticles->pluck('id')->unique();
            if ($uniqueArticleIds->count() !== $clusterArticles->count()) {
                $this->warn("⚠️ '{$group['title']}' - Duplikat article tespit edildi, temizleniyor...");
                $clusterArticles = Article::whereIn('id', $uniqueArticleIds)->with('source')->get();
            }

            // YENİ KURAL: En az 2 FARKLI KAYNAKTAN haber olmalı
            $uniqueSources = $clusterArticles->pluck('source_id')->unique()->count();
            if ($uniqueSources < 2) {
                $this->warn("⚠️ '{$group['title']}' atlandı - sadece {$uniqueSources} kaynak (min 2 gerekli)");
                continue;
            }

            // MAKSIMUM KAYNAK KONTROLÜ: Her kümedeki kaynak sayısı sınırlı olmalı
            $maxSourcesPerCluster = (int) env('MAX_SOURCES_PER_CLUSTER', 10);
            if ($uniqueSources > $maxSourcesPerCluster) {
                $this->warn("⚠️ '{$group['title']}' - {$uniqueSources} kaynak var, max {$maxSourcesPerCluster} ile sınırlanıyor...");
                // En fazla N kaynaktan haber al (öncelik: çeşitlilik)
                $limitedArticles = collect();
                $sourceCounts = [];
                foreach ($clusterArticles as $article) {
                    if (!isset($sourceCounts[$article->source_id])) {
                        $sourceCounts[$article->source_id] = 0;
                    }
                    if (count($sourceCounts) < $maxSourcesPerCluster) {
                        $limitedArticles->push($article);
                        $sourceCounts[$article->source_id]++;
                    } elseif (isset($sourceCounts[$article->source_id])) {
                        $limitedArticles->push($article);
                        $sourceCounts[$article->source_id]++;
                    }
                }
                $clusterArticles = $limitedArticles;
                $uniqueSources = $clusterArticles->pluck('source_id')->unique()->count();
            }

            $this->line("🔗 GRUP BULUNDU: " . $group['title']);
            $this->info("   📰 Kaynak sayısı: {$uniqueSources}");

            // ----------------------
            // MEVCUT CLUSTER KONTROLÜ
            // ----------------------
            $existingCluster = $this->findSimilarCluster($group['title']);

            if ($existingCluster) {
                $this->info("   ♻️ Mevcut cluster bulundu: #{$existingCluster->id} - {$existingCluster->title}");

                // Mevcut cluster'a yeni article'ları ekle
                $existingArticleIds = $existingCluster->articles->pluck('id')->toArray();
                $newArticleIds = array_diff($group['article_ids'], $existingArticleIds);

                if (count($newArticleIds) > 0) {
                    Article::whereIn('id', $newArticleIds)->update([
                        'news_cluster_id' => $existingCluster->id
                    ]);

                    // Cluster'ı yeniden yükle
                    $existingCluster->refresh();
                    $existingCluster->load('articles.source');

                    // Source count'u güncelle
                    $updatedSourceCount = $existingCluster->articles->pluck('source_id')->unique()->count();
                    $existingCluster->update([
                        'source_count' => $updatedSourceCount,
                        'updated_at' => now()
                    ]);

                    $this->info("   ✅ " . count($newArticleIds) . " yeni haber eklendi. Toplam kaynak: {$updatedSourceCount}");

                    // Cluster'ı yeniden analiz et
                    $this->line("   🔄 Cluster yeniden analiz ediliyor...");
                    $allClusterArticles = $existingCluster->articles;
                    $analysis = $gemini->analyzeCluster($allClusterArticles);

                    if ($analysis) {
                        $existingCluster->update([
                            'summary' => $analysis['summary_general'] ?? null,
                            'summary_left' => $analysis['summary_left'] ?? 'Veri yok',
                            'summary_center' => $analysis['summary_center'] ?? 'Veri yok',
                            'summary_right' => $analysis['summary_right'] ?? 'Veri yok',
                            'bias_data' => isset($analysis['bias_stats']) ? [
                                'left' => $analysis['bias_stats']['left_percentage'] ?? 0,
                                'center' => $analysis['bias_stats']['center_percentage'] ?? 0,
                                'right' => $analysis['bias_stats']['right_percentage'] ?? 0,
                            ] : null,
                            'bias_distribution' => $analysis['bias_stats'] ?? null,
                            'analysis_status' => 'completed',
                        ]);
                        $this->info("   ✅ Analiz güncellendi!");
                    }

                    $updatedCount++;
                } else {
                    $this->info("   ℹ️ Tüm haberler zaten bu cluster'da mevcut.");
                }

                continue; // Yeni cluster oluşturma, bir sonraki gruba geç
            }

            // ----------------------
            // YENİ CLUSTER OLUŞTUR
            // ----------------------
            $this->line("   🆕 Yeni cluster oluşturuluyor...");

            $imageUrl = $this->selectBestImage($clusterArticles);

            // Kategori tespiti yap
            $this->line("🏷️ Kategori belirleniyor...");
            $category = $gemini->detectCategory($group['title']);
            $this->info("   → Kategori: {$category}");

            // Kümeyi oluştur
            $cluster = NewsCluster::create([
                'title' => $group['title'],
                'source_count' => $uniqueSources,
                'image_url' => $imageUrl,
                'analysis_status' => 'pending',
                'category' => $category,
            ]);

            // Haberleri güncelle
            Article::whereIn('id', $group['article_ids'])->update([
                'news_cluster_id' => $cluster->id
            ]);

            $this->line("🔍 Küme analiz ediliyor...");

            // Kümeyi analiz et ve perspektif özetlerini al
            $analysis = $gemini->analyzeCluster($clusterArticles);

            if ($analysis) {
                // Analiz başarılı - Veritabanına kaydet
                $cluster->update([
                    'summary' => $analysis['summary_general'] ?? null,
                    'summary_left' => $analysis['summary_left'] ?? 'Veri yok',
                    'summary_center' => $analysis['summary_center'] ?? 'Veri yok',
                    'summary_right' => $analysis['summary_right'] ?? 'Veri yok',
                    'bias_data' => isset($analysis['bias_stats']) ? [
                        'left' => $analysis['bias_stats']['left_percentage'] ?? 0,
                        'center' => $analysis['bias_stats']['center_percentage'] ?? 0,
                        'right' => $analysis['bias_stats']['right_percentage'] ?? 0,
                    ] : null,
                    'bias_distribution' => $analysis['bias_stats'] ?? null,
                    'analysis_status' => 'completed',
                ]);

                $this->info("✅ Analiz tamamlandı!");
            } else {
                // Analiz başarısız
                $cluster->update(['analysis_status' => 'failed']);
                $this->warn("⚠️ Analiz başarısız oldu, küme atlandı.");
            }

            $createdCount++;
        }

        if ($createdCount > 0) {
            $this->info("✅ Toplam $createdCount yeni küme oluşturuldu.");
        }
        if ($updatedCount > 0) {
            $this->info("♻️ Toplam $updatedCount mevcut küme güncellendi.");
        }
        if ($createdCount == 0 && $updatedCount == 0) {
            $this->info("ℹ️ Taranan haberler arasında ortak konu bulunamadı.");
        }
    }

    /**
     * Find similar existing cluster by title similarity
     * @param string $title
     * @return NewsCluster|null
     */
    private function findSimilarCluster($title)
    {
        // Son 7 gün içinde oluşturulan cluster'ları al
        $recentClusters = NewsCluster::where('created_at', '>=', now()->subDays(7))
            ->where('analysis_status', '!=', 'failed')
            ->get();

        $bestMatch = null;
        $bestSimilarity = 0;
        $threshold = 0.70; // %70 benzerlik eşiği

        foreach ($recentClusters as $cluster) {
            $similarity = $this->calculateSimilarity($title, $cluster->title);

            if ($similarity > $bestSimilarity && $similarity >= $threshold) {
                $bestSimilarity = $similarity;
                $bestMatch = $cluster;
            }
        }

        return $bestMatch;
    }

    /**
     * Calculate similarity between two strings
     * @param string $str1
     * @param string $str2
     * @return float Similarity score between 0 and 1
     */
    private function calculateSimilarity($str1, $str2)
    {
        // Normalize strings
        $str1 = mb_strtolower(trim($str1));
        $str2 = mb_strtolower(trim($str2));

        if ($str1 === $str2) {
            return 1.0;
        }

        // Use similar_text for better Turkish language support
        similar_text($str1, $str2, $percent);
        return $percent / 100;
    }

    /**
     * Select the best quality image from cluster articles
     */
    private function selectBestImage($articles)
    {
        $articlesWithImages = $articles->whereNotNull('image_url');

        if ($articlesWithImages->isEmpty()) {
            $this->line("   ℹ️ Küme için resim bulunamadı, kaynak sayfasından çekmeyi deniyorum...");
            return $this->fetchImageFromSourcePage($articles);
        }

        // First priority: Local images
        $localImages = $articlesWithImages->filter(function ($article) {
            return str_starts_with($article->image_url, '/storage/');
        });

        if ($localImages->isNotEmpty()) {
            return $localImages->first()->image_url;
        }

        // Second priority: External images
        return $articlesWithImages->first()->image_url;
    }

    /**
     * Fetch image from the first article's source page
     */
    private function fetchImageFromSourcePage($articles)
    {
        if ($articles->isEmpty()) {
            return null;
        }

        $articlesToTry = $articles->take(3);

        foreach ($articlesToTry as $article) {
            try {
                $response = Http::timeout(5)->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
                ])->get($article->url);

                $html = (string) $response->body();

                if ($response->successful()) {
                    // Look for og:image meta tag
                    if (preg_match('/<meta[^>]+property=["\']og:image["\'][^>]+content=["\']([^"\']+)["\'][^>]*>/i', $html, $matches)) {
                        $this->info("   ✅ Resim bulundu: " . basename($matches[1]));
                        return $matches[1];
                    }
                    // Alternative format
                    if (preg_match('/<meta[^>]+content=["\']([^"\']+)["\'][^>]+property=["\']og:image["\'][^>]*>/i', $html, $matches)) {
                        $this->info("   ✅ Resim bulundu: " . basename($matches[1]));
                        return $matches[1];
                    }
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        $this->warn("   ⚠️ Hiçbir kaynaktan resim çekilemedi");
        return null;
    }
}