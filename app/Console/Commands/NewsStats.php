<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Article;
use App\Models\NewsCluster;
use App\Models\Source;

class NewsStats extends Command
{
    protected $signature = 'news:stats';
    protected $description = 'Haber istatistiklerini gösterir (çekilmiş, kümelenmiş, kümelenmemiş)';

    public function handle()
    {
        $this->info("📊 HABER İSTATİSTİKLERİ\n");

        // Toplam İstatistikler
        $totalArticles = Article::count();
        $clusteredArticles = Article::whereNotNull('news_cluster_id')->count();
        $unclusteredArticles = Article::whereNull('news_cluster_id')->count();
        $analyzedArticles = Article::where('is_analyzed', true)->count();
        $pendingArticles = Article::where('is_analyzed', false)->count();

        $this->table(
            ['Metrik', 'Sayı'],
            [
                ['Toplam Çekilmiş Haber', $totalArticles],
                ['Kümelenmiş Haber', $clusteredArticles],
                ['Kümelenmemiş Haber', $unclusteredArticles],
                ['Analiz Edilmiş Haber', $analyzedArticles],
                ['Analiz Bekleyen Haber', $pendingArticles],
            ]
        );

        // Küme İstatistikleri
        $this->info("\n📦 KÜME İSTATİSTİKLERİ\n");
        $totalClusters = NewsCluster::count();
        $completedClusters = NewsCluster::where('analysis_status', 'completed')->count();
        $pendingClusters = NewsCluster::where('analysis_status', 'pending')->count();
        $failedClusters = NewsCluster::where('analysis_status', 'failed')->count();

        $this->table(
            ['Küme Durumu', 'Sayı'],
            [
                ['Toplam Küme', $totalClusters],
                ['Tamamlanmış Analiz', $completedClusters],
                ['Bekleyen Analiz', $pendingClusters],
                ['Başarısız Analiz', $failedClusters],
            ]
        );

        // Kaynak Bazında İstatistikler
        $this->info("\n📰 KAYNAK BAZINDA İSTATİSTİKLER\n");

        $sources = Source::withCount([
            'articles',
            'articles as clustered_count' => function ($query) {
                $query->whereNotNull('news_cluster_id');
            },
            'articles as unclustered_count' => function ($query) {
                $query->whereNull('news_cluster_id')->where('is_analyzed', true);
            }
        ])->get();

        $sourceData = [];
        foreach ($sources as $source) {
            $sourceData[] = [
                $source->name,
                $source->articles_count,
                $source->clustered_count,
                $source->unclustered_count,
                $source->unclustered_count > 0
                ? round(($source->unclustered_count / max($source->articles_count, 1)) * 100, 1) . '%'
                : '0%'
            ];
        }

        $this->table(
            ['Kaynak', 'Toplam', 'Kümelenmiş', 'Kümelenmemiş', 'Kümelenmeme Oranı'],
            $sourceData
        );

        // Son 24 Saatteki Aktivite
        $this->info("\n🕒 SON 24 SAATTEKİ AKTİVİTE\n");

        $articlesLast24h = Article::where('created_at', '>=', now()->subDay())->count();
        $clustersLast24h = NewsCluster::where('created_at', '>=', now()->subDay())->count();

        $this->table(
            ['Aktivite', 'Sayı'],
            [
                ['Son 24 Saatte Çekilen Haber', $articlesLast24h],
                ['Son 24 Saatte Oluşan Küme', $clustersLast24h],
            ]
        );

        // Öneriler
        if ($unclusteredArticles > 50) {
            $this->warn("\n⚠️ {$unclusteredArticles} kümelenmemiş haber var. 'php artisan news:cluster' komutunu çalıştırın.");
        }

        if ($pendingArticles > 100) {
            $this->warn("\n⚠️ {$pendingArticles} analiz bekleyen haber var. 'php artisan news:cluster' komutunu çalıştırın.");
        }

        if ($failedClusters > 0) {
            $this->error("\n❌ {$failedClusters} başarısız küme analizi var. Loglara bakın.");
        }

        $this->info("\n✅ İstatistikler başarıyla gösterildi!");

        return 0;
    }
}
