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

        return view('news.index', compact('newsClusters', 'category'));
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
