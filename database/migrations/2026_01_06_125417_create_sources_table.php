<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // Örn: Sözcü
            $table->string('url');            // Websitesi Linki
            $table->string('rss_url');        // Haberleri çekeceğimiz RSS adresi
            $table->integer('base_bias');     // -10 (Sol) ile +10 (Sağ) arası sabit puan
            $table->string('logo')->nullable(); // Gazete logosu (url)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sources');
    }
};
