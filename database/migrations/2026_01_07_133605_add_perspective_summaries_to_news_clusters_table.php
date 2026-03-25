<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('news_clusters', function (Blueprint $table) {
            // Perspektif bazlı özetler
            $table->text('summary_left')->nullable()->after('summary');
            $table->text('summary_center')->nullable()->after('summary_left');
            $table->text('summary_right')->nullable()->after('summary_center');
        });
    }

    public function down(): void
    {
        Schema::table('news_clusters', function (Blueprint $table) {
            $table->dropColumn(['summary_left', 'summary_center', 'summary_right']);
        });
    }
};
