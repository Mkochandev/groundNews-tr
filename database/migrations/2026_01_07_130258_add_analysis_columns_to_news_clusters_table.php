<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('news_clusters', function (Blueprint $table) {
            // summary kolonu zaten var, sadece bias_data ve analysis_status ekle

            // Siyasi Dağılım (Örn: Sol, Sağ, Merkez yüzdeleri) - JSON formatında
            if (!Schema::hasColumn('news_clusters', 'bias_data')) {
                $table->json('bias_data')->nullable()->after('summary');
            }

            // Analiz durumu (Aynı haberi tekrar tekrar analiz etmemek için)
            if (!Schema::hasColumn('news_clusters', 'analysis_status')) {
                $table->enum('analysis_status', ['pending', 'processing', 'completed', 'failed'])
                    ->default('pending')
                    ->after('source_count');
            }
        });
    }

    public function down(): void
    {
        Schema::table('news_clusters', function (Blueprint $table) {
            // Sadece bu migration'ın eklediği kolonları kaldır
            $table->dropColumn(['bias_data', 'analysis_status']);
        });
    }
};