<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use App\Services\GeminiAnalystService;
use App\Http\Controllers\NewsController;
use Gemini\Laravel\Facades\Gemini;


Route::get('/', [NewsController::class, 'index'])->name('home');

// Footer pages
Route::view('/hakkimizda', 'pages.about')->name('about');
Route::view('/metodoloji', 'pages.methodology')->name('methodology');
Route::view('/gizlilik-politikasi', 'pages.privacy')->name('privacy');
Route::view('/iletisim', 'pages.contact')->name('contact');

// News detail route
Route::get('/haber/{id}', [NewsController::class, 'show'])->name('news.show');

// Debug route - küme durumunu kontrol et
Route::get('/debug/clusters', function () {
    $all = \App\Models\NewsCluster::count();
    $completed = \App\Models\NewsCluster::where('analysis_status', 'completed')->count();
    $pending = \App\Models\NewsCluster::where('analysis_status', 'pending')->count();
    $failed = \App\Models\NewsCluster::where('analysis_status', 'failed')->count();

    $recent = \App\Models\NewsCluster::orderBy('id', 'desc')->take(10)->get(['id', 'title', 'analysis_status', 'created_at']);

    return [
        'total_clusters' => $all,
        'completed' => $completed,
        'pending' => $pending,
        'failed' => $failed,
        'recent_clusters' => $recent,
    ];
});

// Category routes - will be handled by NewsController with category parameter
// These routes are kept for cleaner URLs, but functionality is also available via /?category=xxx
Route::get('/gundem', function () {
    return app(NewsController::class)->index(request()->merge(['category' => 'gundem']));
})->name('category.gundem');

Route::get('/ekonomi', function () {
    return app(NewsController::class)->index(request()->merge(['category' => 'ekonomi']));
})->name('category.ekonomi');

Route::get('/siyaset', function () {
    return app(NewsController::class)->index(request()->merge(['category' => 'siyaset']));
})->name('category.siyaset');

Route::get('/dis-politika', function () {
    return app(NewsController::class)->index(request()->merge(['category' => 'dis-politika']));
})->name('category.dis-politika');

Route::get('/yerel', function () {
    return app(NewsController::class)->index(request()->merge(['category' => 'yerel']));
})->name('category.yerel');

Route::get('/senin-icin', function () {
    return app(NewsController::class)->index(request()->merge(['category' => 'senin-icin']));
})->name('category.senin-icin');

Route::get('/golge-gundem', function () {
    return app(NewsController::class)->index(request()->merge(['category' => 'golge-gundem']));
})->name('category.golge-gundem');

Route::get('/teknoloji', function () {
    return app(NewsController::class)->index(request()->merge(['category' => 'teknoloji']));
})->name('category.teknoloji');

Route::get('/spor', function () {
    return app(NewsController::class)->index(request()->merge(['category' => 'spor']));
})->name('category.spor');

Route::get('/blindspot', function () {
    return app(NewsController::class)->index(request()->merge(['category' => 'blindspot']));
})->name('category.blindspot');

// TEMPORARY: Mock endpoint for testing while API quota is exhausted
Route::get('/test-gemini-mock', function () {
    return [
        "common_summary" => "Emeklilere yeni maaş zammı açıklandı. Hükümet tarafından yapılan açıklamaya göre, emekli maaşlarına önemli bir artış yapılacak. Ancak, farklı kaynaklarda zam oranı ve etkisine dair yorumlar değişiklik gösteriyor.",
        "bias_distribution" => [
            "left" => 35,
            "center" => 25,
            "right" => 40
        ],
        "framing_analysis" => "İktidar yanlısı medya kaynaklarında 'rekor zam' ve 'müjde' gibi olumlu kelimeler kullanılırken, muhalif medya 'açlık sınırının altında' vurgusunu yaparak eleştirel bir yaklaşım sergiliyor. Merkez medya ise daha tarafsız bir dil kullanarak sadece rakamsal verileri paylaşıyor ve yorumsuz haber aktarımı yapıyor."
    ];
});

Route::get('/test-gemini', function () {
    // Cache the result for 5 minutes to avoid hitting rate limits
    return Cache::remember('test-gemini-analysis', 300, function () {
        // 1. Sanki veritabanından gelmiş gibi 3 farklı başlık uyduruyoruz
        $ornekBasliklar = [
            "Hükümetten emekliye rekor zam müjdesi",           // İktidar dili (Sabah vb.)
            "Emekli zammı yine açlık sınırının altında kaldı", // Muhalif dili (Sözcü vb.)
            "Yeni emekli maaş zammı oranları belli oldu"       // Merkez dili (NTV vb.)
        ];

        // 2. Senin yazdığın servisi çağırıyoruz
        $servis = new GeminiAnalystService();
        $sonuc = $servis->analyzeNewsGroup($ornekBasliklar);

        // 3. Sonucu ekrana basıyoruz
        return $sonuc;
    });
});



Route::get('/list-models', function () {
    // API'nin sana sunduğu tüm modelleri listeler
    $models = Gemini::listModels();

    // Sadece isimleri alıp ekrana basar
    return collect($models->models)
        ->map(fn($m) => $m->name)
        ->values();
});





Route::get('/gemini-check', function () {
    try {
        // DÜZELTME: listModels() yerine models()->list() kullanıyoruz
        $response = Gemini::models()->list();

        $models = collect($response->models)
            ->map(fn($m) => $m->name)
            ->values();

        return response()->json([
            'status' => 'success',
            'count' => count($models),
            'models' => $models
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
});