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

        // Yeterli haber çek: sol(6) + orta featured(1) + orta grid(20) + sağ(6) = max 33
        $newsClusters = $query->orderBy('updated_at', 'desc')->get();

        // Her bölüm için çakışmayan ayrı dilimler
        $sidebarBriefing  = $newsClusters->slice(0, 3);  // Sol üst: 1-3. haberler
        $sidebarFeatured  = $newsClusters->slice(3, 3);  // Sol alt: 4-6. haberler
        $mainFeatured     = $newsClusters->slice(6, 1)->first();  // Orta büyük: 7. haber
        $mainGrid         = $newsClusters->slice(7, 20); // Orta grid: 8-27. haberler
        $blindspots       = $newsClusters->filter(function ($cluster) {
            $bias = is_array($cluster->bias_data)
                ? $cluster->bias_data
                : json_decode($cluster->bias_data, true);
            $max = max($bias['left'] ?? 0, $bias['center'] ?? 0, $bias['right'] ?? 0);
            return $max > 50; // %50'den fazla tek tarafa eğilimli
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
