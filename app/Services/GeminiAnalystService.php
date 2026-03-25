<?php

namespace App\Services;

use Gemini\Laravel\Facades\Gemini;
use Gemini\Data\Content;
use Gemini\Data\GenerationConfig;
use Gemini\Enums\ResponseMimeType;
use Gemini\Factory;

class GeminiAnalystService
{
    private static $currentKeyIndex = 0;

    /**
     * Get a Gemini Client instance with rotated keys if needed
     */
    private function getGeminiModel($modelName)
    {
        // 1. .env dosyasından anahtarları al (Virgülle ayrılmış)
        $envKey = env('GEMINI_API_KEYS', env('GEMINI_API_KEY'));
        $keys = explode(',', $envKey);

        // Boşlukları temizle ve boş kayıtları at
        $keys = array_filter(array_map('trim', $keys));

        // Eğer hiç anahtar yoksa mecburen Facade'a düş (Hata verecektir)
        if (empty($keys)) {
            return Gemini::generativeModel(model: $modelName);
        }

        // 2. Mevcut anahtarı seç (Tek anahtar varsa index 0 olur)
        $apiKey = $keys[self::$currentKeyIndex % count($keys)];

        // 3. Factory kullanarak yeni instance oluştur
        // Bu yöntem global 'gemini.api_key' konfigürasyonundan bağımsız çalışır
        return (new Factory())->withApiKey($apiKey)->make()->generativeModel(model: $modelName);
    }

    /**
     * Rotate to the next API key
     */
    private function rotateApiKey()
    {
        $envKey = env('GEMINI_API_KEYS', env('GEMINI_API_KEY'));
        $keys = explode(',', $envKey);
        $keys = array_filter(array_map('trim', $keys));

        if (count($keys) > 1) {
            self::$currentKeyIndex++;
            $nextKeyIndex = self::$currentKeyIndex % count($keys);
            $keyName = "Key #" . ($nextKeyIndex + 1);
            echo "\n🔄 API Key değiştiriliyor -> $keyName\n";
            \Log::info("Gemini API Key rotated to index: $nextKeyIndex");
            return true;
        }
        return false;
    }

    public function analyzeNewsGroup(array $titles): array
    {
        return [];
    }

    /**
     * Detect category for a news title using Gemini API
     * 
     * @param string $title News title to categorize
     * @return string Category slug (gundem, ekonomi, siyaset, etc.)
     */
    public function detectCategory(string $title): string
    {
        $systemInstruction = "
            Sen bir haber kategorizasyon uzmanısın. 
            Türk medyası için haberleri kategorilere ayırıyorsun.
            Sadece verilen kategorilerden birini seç ve kategori ismini döndür.
        ";

        $prompt = "
            Aşağıdaki haber başlığını en uygun kategoriye ata:
            
            Kategoriler:
            - gundem (gündem/genel haberler, toplumsal olaylar)
            - ekonomi (ekonomik haberler, piyasalar, iş dünyası)
            - siyaset (siyasi haberler, politika, hükümet)
            - dis-politika (dış politika, uluslararası ilişkiler)
            - yerel (yerel haberler, şehir haberleri)
            - teknoloji (teknoloji, bilim, inovasyon)
            - spor (spor haberleri, futbol, basketbol vb.)
            
            Sadece kategori ismini döndür. Başka bir şey yazma.
            
            Başlık: \"{$title}\"
        ";

        $config = new GenerationConfig(
            temperature: 0.2 // Düşük temperature - kategori tespiti tutarlı olmalı
        );

        $modelName = 'gemini-flash-latest';
        $maxRetries = 3; // Kategori tespiti için daha az retry
        $retryCount = 0;

        while ($retryCount < $maxRetries) {
            try {
                $response = $this->getGeminiModel($modelName)
                    ->withSystemInstruction(Content::parse($systemInstruction))
                    ->withGenerationConfig($config)
                    ->generateContent($prompt);

                // Yanıtın bloke edilip edilmediğini kontrol et
                if (empty($response->candidates)) {
                    $blockReason = $response->promptFeedback->blockReason->value ?? 'UNKNOWN';
                    \Log::warning("Gemini kategori tespiti için prompt bloke edildi: {$title}, Sebep: {$blockReason}");
                    return 'gundem'; // Varsayılan kategori döndür
                }

                $category = trim($response->text());


                // Kategorinin geçerli olduğunu kontrol et
                $validCategories = ['gundem', 'ekonomi', 'siyaset', 'dis-politika', 'yerel', 'teknoloji', 'spor'];

                if (in_array($category, $validCategories)) {
                    return $category;
                }

                // Geçersiz kategori, varsayılan olarak gundem döndür
                \Log::warning("Gemini geçersiz kategori döndü: {$category}, varsayılan: gundem");
                return 'gundem';

            } catch (\Exception $e) {
                $errorMessage = $e->getMessage();

                // Quota hatası durumunda key rotate et
                if (
                    strpos($errorMessage, '429') !== false ||
                    strpos($errorMessage, 'quota') !== false ||
                    strpos($errorMessage, 'RESOURCE_EXHAUSTED') !== false
                ) {
                    $retryCount++;

                    if ($this->rotateApiKey()) {
                        continue;
                    }

                    if ($retryCount < $maxRetries) {
                        $waitTime = 5 * $retryCount;
                        echo "\n⚠️ Kategori tespiti quota hatası, {$waitTime}s bekleniyor...\n";
                        sleep($waitTime);
                        continue;
                    }
                }

                // Hata durumunda varsayılan kategori döndür
                \Log::error("Kategori tespiti hatası: {$errorMessage}");
                return 'gundem';
            }
        }

        return 'gundem'; // Fallback
    }

    public function clusterNews($articles)
    {
        // Giden veriyi hazırla
        $inputData = $articles->map(fn($a) => "ID:{$a->id} - {$a->title}")->join("\n");

        $systemInstruction = "
            Sen uzman bir editörsün. Aşağıdaki haber başlıklarını analiz et ve AYNI OLAYI anlatanları gruplandır.
            Kurallar:
            1. Sadece gerçekten aynı olayı anlatanları grupla.
            2. Çıktı kesinlikle geçerli bir JSON olmalı.
            3. JSON formatı: [{'title': 'Ortak Başlık', 'article_ids': [1, 5, 20]}, ...]
        ";

        $prompt = "Aşağıdaki haber listesini gruplandır:\n\n" . $inputData;

        // RETRY MECHANISM: 429 hatası alırsak bekleyip tekrar dene
        $maxRetries = 10; // Quota çok sıkı olduğu için deneme sayısını artırdık
        $retryCount = 0;
        $config = new GenerationConfig(
            responseMimeType: ResponseMimeType::APPLICATION_JSON,
            temperature: 0.3
        );

        // Model: gemini-flash-latest (API'de çalışan model)
        $modelName = 'gemini-flash-latest';

        while ($retryCount < $maxRetries) {
            try {
                // MULTI-KEY SUPPORT: Get model with current key
                $response = $this->getGeminiModel($modelName)
                    ->withSystemInstruction(Content::parse($systemInstruction))
                    ->withGenerationConfig($config)
                    ->generateContent($prompt);

                $text = $response->text();

                // DEBUG: RAW Çıktıyı görelim
                echo "\n-------- RAW GEMINI OUTPUT --------\n";
                echo $text ? $text : "!!! BOŞ YANIT GELDİ !!!";
                echo "\n-----------------------------------\n";

                // Temizlik
                $text = preg_replace('/^```json\s*/i', '', $text);
                $text = preg_replace('/^```\s*/i', '', $text);
                $text = preg_replace('/\s*```$/', '', $text);
                $text = trim($text);

                $json = json_decode($text, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    echo "\n❌ JSON HATASI: " . json_last_error_msg();
                    return [];
                }

                return $json; // Başarılı, döndür

            } catch (\Exception $e) {
                $errorMessage = $e->getMessage();

                // 429 (Rate Limit) veya Quota hatası mı?
                if (
                    strpos($errorMessage, '429') !== false ||
                    strpos($errorMessage, 'quota') !== false ||
                    strpos($errorMessage, 'RESOURCE_EXHAUSTED') !== false ||
                    strpos($errorMessage, 'API Key') !== false // API Key hatalarını da yakala
                ) {

                    $retryCount++;

                    // 1. Önce başka key var mı diye bak ve değiştir
                    if ($this->rotateApiKey()) {
                        echo "\n⚠️ QUOTA HATASI - Yeni key ile hemen deneniyor...";
                        continue; // Beklemeden diğer key ile dene
                    }

                    // 2. Key kalmadıysa bekle
                    $waitTime = 10 * $retryCount; // Default: 10s, 20s, 30s...

                    // API'den gelen "Please retry in X s" mesajını yakala
                    if (preg_match('/Please retry in\s+([0-9\.]+)\s*s/i', $errorMessage, $matches)) {
                        $waitTime = ceil((float) $matches[1]) + 5; // Güvenlik payı ekle (+5sn)
                    }

                    if ($retryCount < $maxRetries) {
                        echo "\n⚠️ QUOTA HATASI (Deneme $retryCount/$maxRetries): " . $errorMessage;
                        echo "\n⏳ {$waitTime} saniye bekleniyor...";
                        sleep($waitTime);
                        echo " Tekrar deneniyor...\n";
                        continue; // Tekrar dene
                    }
                }

                // Başka bir hata veya max retry aşıldı
                echo "\n🔥 API HATASI: " . $errorMessage;
                return [];
            }
        }

        return []; // Tüm denemeler başarısız
    }

    /**
     * Haber kümesini analiz ederek özet ve taraflılık verisi çıkarır
     * 
     * @param \Illuminate\Support\Collection $articles Makale koleksiyonu
     * @return array|null Analiz sonucu (summary ve bias_data) veya null
     */
    public function analyzeCluster($articles)
    {
        // Makale başlıklarını, kaynaklarını, eğilimlerini ve URL'lerini birleştir
        $newsText = $articles->map(function ($article) {
            $source = $article->source->name ?? 'Bilinmeyen Kaynak';
            $bias = $article->source->base_bias ?? 0;
            $domain = parse_url($article->url, PHP_URL_HOST);

            // Bias label belirleme
            if ($bias <= -5) {
                $biasLabel = "Sol";
            } elseif ($bias >= 5) {
                $biasLabel = "Sağ";
            } else {
                $biasLabel = "Merkez";
            }

            return "- {$article->title} (Kaynak: {$source}, Eğilim: {$biasLabel}, Domain: {$domain})";
        })->join("\n");

        $systemInstruction = "
            Sen uzman bir haber analisti ve siyaset bilimcisin.
            Her haber kaynağının siyasi eğilimi verilmiştir (Sol/Merkez/Sağ).
            Bias yüzdelerini hesaplarken MUTLAKA kaynak eğilimlerini kullan.
            Görüşün her zaman objektif olmalıdır.
        ";

        $prompt = "
            Aşağıdaki haber başlıklarını analiz et:
            
            {$newsText}

            Görevlerin:
            1) Olayın tarafsız ana özetini çıkar (summary_general). 
               ÖNEMLİ: Bu özet EN AZ 3-5 cümle uzunluğunda, detaylı ve kapsamlı olmalıdır. 
               Olayın ne olduğunu, kim/kimler dahil olduğunu, nerede ve ne zaman gerçekleştiğini açıkça belirt.
               Tek cümlelik kısa özetler KABUL EDİLMEZ.
            2) Sol eğilimli kaynakların olayı ele alış biçimini ve vurguladıkları noktaları özetle (summary_left). Yoksa 'Veri yok'.
            3) Merkez kaynakların aktardığı nötr detayları özetle (summary_center). Yoksa 'Veri yok'.
            4) Sağ eğilimli kaynakların olayı ele alış biçimini ve vurguladıkları noktaları özetle (summary_right). Yoksa 'Veri yok'.
            5) Siyasi eğilim yüzdeliklerini ver (bias_stats).
               ÖNEMLİ: Bias yüzdelerini hesaplarken KAYNAK EĞİLİMLERİNİ kullan!
               Formül:
               - Sol eğilimli kaynak sayısı / Toplam kaynak sayısı * 100 = left_percentage
               - Merkez eğilimli kaynak sayısı / Toplam kaynak sayısı * 100 = center_percentage  
               - Sağ eğilimli kaynak sayısı / Toplam kaynak sayısı * 100 = right_percentage
               Yüzdeler toplamı MUTLAKA 100 olmalı.
            6) Haberin alındığı domain listesini çıkar (sources_list).

            ÇIKTI FORMATINI KESINLIKLE KORU:
            {
                \"summary_general\": \"Olayın detaylı, kapsamlı ana özeti (en az 3-5 cümle)\",
                \"summary_left\": \"Sol eğilimli kaynakların olayı ele alış biçimi\",
                \"summary_center\": \"Merkez kaynakların aktardığı nötr detaylar\",
                \"summary_right\": \"Sağ eğilimli kaynakların olayı ele alış biçimi\",
                \"bias_stats\": {
                    \"left_percentage\": 30,
                    \"center_percentage\": 40,
                    \"right_percentage\": 30
                },
                \"sources_list\": [\"sabah.com.tr\", \"sozcu.com.tr\", \"ntv.com.tr\"]
            }
        ";

        // RETRY MECHANISM: 429 hatası alırsak bekleyip tekrar dene
        $maxRetries = 10;
        $retryCount = 0;
        $config = new GenerationConfig(
            responseMimeType: ResponseMimeType::APPLICATION_JSON,
            temperature: 0.5 // Daha detaylı ve yaratıcı özetler için artırıldı
        );

        // Model: gemini-flash-latest (API'de çalışan model)
        $modelName = 'gemini-flash-latest';

        while ($retryCount < $maxRetries) {
            try {
                // MULTI-KEY SUPPORT
                $response = $this->getGeminiModel($modelName)
                    ->withSystemInstruction(Content::parse($systemInstruction))
                    ->withGenerationConfig($config)
                    ->generateContent($prompt);

                // Yanıtın bloke edilip edilmediğini kontrol et
                if (empty($response->candidates)) {
                    $blockReason = $response->promptFeedback->blockReason->value ?? 'UNKNOWN';
                    \Log::warning("Gemini analyzeCluster prompt bloke edildi. Küme atlanıyor. Sebep: {$blockReason}");
                    return null;
                }

                $text = $response->text();

                // JSON temizliği
                $text = preg_replace('/^```json\s*/i', '', $text);
                $text = preg_replace('/^```\s*/i', '', $text);
                $text = preg_replace('/\s*```$/', '', $text);
                $text = trim($text);

                $json = json_decode($text, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    \Log::error('Gemini analyzeCluster JSON hatası: ' . json_last_error_msg());
                    return null;
                }

                // Yanıtın doğru formatta olduğunu kontrol et
                if (!isset($json['summary_general']) || !isset($json['bias_stats'])) {
                    \Log::error('Gemini analyzeCluster eksik alan: ' . json_encode($json));
                    return null;
                }

                return $json; // Başarılı, döndür

            } catch (\Exception $e) {
                $errorMessage = $e->getMessage();

                // 429 (Rate Limit) veya Quota hatası mı?
                if (
                    strpos($errorMessage, '429') !== false ||
                    strpos($errorMessage, 'quota') !== false ||
                    strpos($errorMessage, 'RESOURCE_EXHAUSTED') !== false ||
                    strpos($errorMessage, 'API Key') !== false
                ) {

                    $retryCount++;

                    // 1. Önce başka key var mı diye bak ve değiştir
                    if ($this->rotateApiKey()) {
                        \Log::info("Quota Error - Rotated to next API key immediately.");
                        continue;
                    }

                    // 2. Key kalmadıysa bekle
                    $waitTime = 10 * $retryCount; // Default: 10s, 20s, 30s...

                    // API'den gelen "Please retry in X s" mesajını yakala
                    if (preg_match('/Please retry in\s+([0-9\.]+)\s*s/i', $errorMessage, $matches)) {
                        $waitTime = ceil((float) $matches[1]) + 5; // Güvenlik payı ekle (+5sn)
                    }

                    if ($retryCount < $maxRetries) {
                        \Log::warning("⚠️ QUOTA HATASI (Deneme $retryCount/$maxRetries): Bekleniyor {$waitTime}s...");
                        \Log::info("Rate Limit Wait: {$waitTime}s");
                        sleep($waitTime);
                        \Log::info("Tekrar deneniyor...");
                        continue; // Tekrar dene
                    }
                }

                // Başka bir hata veya max retry aşıldı
                \Log::error('Gemini analyzeCluster API hatası: ' . $errorMessage);
                return null;
            }
        }

        return null; // Tüm denemeler başarısız
    }
}