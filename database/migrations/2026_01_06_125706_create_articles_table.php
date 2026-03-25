<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_id')->constrained()->onDelete('cascade'); // Hangi gazete?
            $table->string('title');          // Başlık
            $table->string('url')->unique();  // Link (Aynı haberi tekrar kaydetmemek için unique)
            $table->text('description')->nullable(); // Kısa özet (RSS'den gelen)
            $table->dateTime('published_at'); // Yayınlanma tarihi
            $table->boolean('is_analyzed')->default(false); // Gemini bunu analiz etti mi?
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};