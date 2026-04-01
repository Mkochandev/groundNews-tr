<?php

namespace App\Http\Controllers;

use App\Models\NewsCluster;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Ana sayfa - Analiz edilmiş haber kümelerini göster
     */
    public function index(Request $request)
    {
        $category = $request->get('category');

        // analysis_status = 'completed' olan kümeleri en yeniden eskiye sırala
        $query = NewsCluster::where('analysis_status', 'completed');

        // Kategori filtresi varsa uygula
        if ($category) {
            $query->where('category', $category);
        }

        $newsClusters = $query->orderBy('updated_at', 'desc')->get();
        $total = $newsClusters->count();

        // Orta alan HER ZAMAN önce gelir — kategori filtresiyle az haber olsa bile boş kalmaz
        $mainFeatured = $newsClusters->first();           // Orta büyük: her zaman 1. haber
        $mainGrid     = $newsClusters->slice(1, 20);      // Orta grid: 2.+ haberler

        // Sol sidebar: yeterli haber varsa farklı haberler, yoksa aynı haberler (preview amaçlı)
        // Gerçek haber sitelerinde de sidebar = manşet listesi olarak çakışabilir
        if ($total > 6) {
            // Yeterli haber var — sidebar orta alanla çakışmıyor
            $sidebarBriefing = $newsClusters->slice($total - 6, 3); // Son 6'dan ilk 3
            $sidebarFeatured = $newsClusters->slice($total - 3, 3); // Son 3
        } else {
            // Az haber var — sidebar, orta alanın başlıklarını gösteriyor (preview)
            $sidebarBriefing = $newsClusters->take(3);
            $sidebarFeatured = $newsClusters->slice(3, 3);
        }

        // Gölge Gündem: tek tarafa %50+ eğilimli haberler
        $blindspots = $newsClusters->filter(function ($cluster) {
            $bias = is_array($cluster->bias_data)
                ? $cluster->bias_data
                : json_decode($cluster->bias_data, true);
            $max = max($bias['left'] ?? 0, $bias['center'] ?? 0, $bias['right'] ?? 0);
            return $max > 50;
        })->take(6);

        return view('news.index', compact(
            'newsClusters',
            'category',
            'sidebarBriefing',
            'sidebarFeatured',
            'mainFeatured',
            'mainGrid',
            'blindspots'
        ));
    }

    /**
     * Haber detay sayfası - Perspektif analizi göster
     */
    public function show($id)
    {
        $newsCluster = NewsCluster::with('articles.source')->findOrFail($id);

        return view('news.show', compact('newsCluster'));
    }
}
