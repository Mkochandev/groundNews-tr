<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\NewsCluster;
use App\Jobs\ProcessNewsAnalysis;

class AutoPilotNews extends Command
{
    protected $signature = 'news:autopilot';
    protected $description = 'Haberleri çek ve analiz sırasına koy';

    public function handle()
    {
        $this->info('Bot çalışıyor...');

        // 1. Burada Scraper fonksiyonunu çağır (Haberleri çek)
        // fetchLatestNews(); 

        // 2. Analiz edilmemiş grupları bul ve Gemini'a gönder
        // Örnek: Son 1 saatteki analiz edilmemiş kümeler
        $clusters = NewsCluster::where('is_analyzed', false)->get();

        foreach ($clusters as $cluster) {
            ProcessNewsAnalysis::dispatch($cluster->id);
            $this->info("Küme {$cluster->id} analize gönderildi.");
        }

        $this->info('Tamamlandı! Toplam ' . $clusters->count() . ' küme işleme alındı.');
    }
}
