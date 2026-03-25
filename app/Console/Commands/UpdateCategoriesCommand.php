<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\NewsCluster;
use App\Services\GeminiAnalystService;

class UpdateCategoriesCommand extends Command
{
    protected $signature = 'news:update-categories';
    protected $description = 'Mevcut haber kümelerinin kategorilerini güncelle';

    public function handle(GeminiAnalystService $gemini)
    {
        $this->info("Kategorisiz haber kümeleri aranıyor...");

        // Kategorisi null olan kümeleri al
        $clusters = NewsCluster::whereNull('category')->get();

        if ($clusters->isEmpty()) {
            $this->info("Tüm kümelerin kategorisi zaten atanmış!");
            return;
        }

        $this->info($clusters->count() . " küme bulundu. Kategoriler güncelleniyor...");

        $progressBar = $this->output->createProgressBar($clusters->count());
        $progressBar->start();

        foreach ($clusters as $cluster) {
            // Kategori tespiti yap
            $category = $gemini->detectCategory($cluster->title);

            // Güncelle
            $cluster->update(['category' => $category]);

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();
        $this->info("✅ Toplam {$clusters->count()} kümenin kategorisi güncellendi!");

        // Özet bilgi
        $this->newLine();
        $this->table(
            ['Kategori', 'Küme Sayısı'],
            NewsCluster::selectRaw('category, COUNT(*) as count')
                ->groupBy('category')
                ->get()
                ->map(fn($item) => [$item->category, $item->count])
                ->toArray()
        );
    }
}
