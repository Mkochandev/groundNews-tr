<?php

namespace App\Jobs;

use App\Models\NewsCluster; // Gruplanmış haber modelin
use App\Services\GeminiAnalystService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessNewsAnalysis implements ShouldQueue
{
    use Queueable;

    public function __construct(protected $clusterId)
    {
    }

    public function handle(GeminiAnalystService $service)
    {
        $cluster = NewsCluster::with('articles')->find($this->clusterId);
        $titles = $cluster->articles->pluck('title')->toArray();

        // Gemini'dan analiz al
        $analysis = $service->analyzeNewsGroup($titles);

        // Veritabanını güncelle
        $cluster->update([
            'summary' => $analysis['common_summary'],
            'bias_left' => $analysis['bias_distribution']['left'],
            'bias_center' => $analysis['bias_distribution']['center'],
            'bias_right' => $analysis['bias_distribution']['right'],
            'analysis_text' => $analysis['framing_analysis'],
            'is_analyzed' => true
        ]);
    }
}