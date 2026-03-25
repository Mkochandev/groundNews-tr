<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('news_clusters', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Gemini'ın belirleyeceği "Ortak Başlık"
            $table->text('summary')->nullable(); // Olayın tarafsız özeti
            $table->string('category')->nullable(); // Ekonomi, Siyaset vb.

            // Bu olay kaç farklı kaynaktan doğrulandı?
            $table->integer('source_count')->default(0);

            // Siyasi Dağılım (Gemini hesaplayacak)
            // Örn: {"left": 40, "center": 10, "right": 50}
            $table->json('bias_distribution')->nullable();

            $table->timestamps();
        });

        // Article tablosuna 'cluster_id' eklememiz lazım
        Schema::table('articles', function (Blueprint $table) {
            $table->foreignId('news_cluster_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_clusters');
    }
};
