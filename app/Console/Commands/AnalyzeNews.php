<?php

namespace App\Console\Commands;

use App\Models\NewsCluster;
use App\Services\GeminiAnalystService;
use Illuminate\Console\Command;

class AnalyzeNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:analyze';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Haber kümelerini analiz eder ve özet/taraflılık verisi çıkarır';

    protected GeminiAnalystService $geminiService;

    /**
     * Create a new command instance.
     */
    public function __construct(GeminiAnalystService $geminiService)
    {
        parent::__construct();
        $this->geminiService = $geminiService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Analiz bekleyen haber kümeleri aranıyor...');

        // analysis_status = 'pending' olan TÜM kümeleri getir (test için source_count kısıtlaması kaldırıldı)
        $clusters = NewsCluster::where('analysis_status', 'pending')
            ->get();

        if ($clusters->isEmpty()) {
            $this->info('✅ Analiz bekleyen küme bulunamadı.');
            return Command::SUCCESS;
        }

        $this->info("📊 Toplam {$clusters->count()} küme analiz edilecek.");

        $successCount = 0;
        $failedCount = 0;

        foreach ($clusters as $cluster) {
            $this->info("⏳ Küme analiz ediliyor: [{$cluster->id}] {$cluster->title}");

            try {
                // Durumu 'processing' olarak güncelle
                $cluster->update(['analysis_status' => 'processing']);

                // Kümeye ait makaleleri getir
                $articles = $cluster->articles;

                if ($articles->isEmpty()) {
                    $this->warn("⚠️  Küme #{$cluster->id} için makale bulunamadı, atlanıyor.");
                    $cluster->update(['analysis_status' => 'failed']);
                    $failedCount++;
                    continue;
                }

                // Gemini ile analiz et
                $result = $this->geminiService->analyzeCluster($articles);

                if ($result === null || !isset($result['summary_general']) || !isset($result['bias_stats'])) {
                    $this->error("❌ Küme #{$cluster->id} analizi başarısız (Geçersiz yanıt)");
                    $cluster->update(['analysis_status' => 'failed']);
                    $failedCount++;
                    continue;
                }

                // bias_data formatını oluştur (eski format için uyumluluk)
                $biasData = [
                    'left' => $result['bias_stats']['left_percentage'] ?? 0,
                    'center' => $result['bias_stats']['center_percentage'] ?? 0,
                    'right' => $result['bias_stats']['right_percentage'] ?? 0,
                ];

                // Sonuçları veritabanına kaydet
                $cluster->update([
                    'summary' => $result['summary_general'],
                    'summary_left' => $result['summary_left'] ?? 'Veri yok',
                    'summary_center' => $result['summary_center'] ?? 'Veri yok',
                    'summary_right' => $result['summary_right'] ?? 'Veri yok',
                    'bias_data' => $biasData,
                    'bias_distribution' => $result['bias_stats'] ?? null,
                    'analysis_status' => 'completed'
                ]);

                $this->info("✅ Küme #{$cluster->id} başarıyla analiz edildi.");
                $successCount++;

            } catch (\Exception $e) {
                $this->error("❌ Küme #{$cluster->id} analizi sırasında hata: {$e->getMessage()}");

                // Hata durumunda failed olarak işaretle
                $cluster->update(['analysis_status' => 'failed']);
                $failedCount++;
            }

            // API limitlerini aşmamak için kısa bir bekleme
            usleep(500000); // 0.5 saniye
        }

        $this->newLine();
        $this->info("🎉 Analiz tamamlandı!");
        $this->info("✅ Başarılı: {$successCount}");
        $this->info("❌ Başarısız: {$failedCount}");

        return Command::SUCCESS;
    }
}
