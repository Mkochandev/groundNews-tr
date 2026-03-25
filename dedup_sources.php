<?php

use Illuminate\Support\Facades\DB;
use App\Models\Source;
use App\Models\Article;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$duplicates = Source::select('name')
    ->groupBy('name')
    ->havingRaw('COUNT(*) > 1')
    ->get();

echo "Found " . $duplicates->count() . " duplicate source names.\n";

foreach ($duplicates as $dup) {
    echo "Processing: {$dup->name}\n";

    // Get all sources with this name
    $sources = Source::where('name', $dup->name)->orderBy('id')->get();

    // First one is canonical (master)
    $master = $sources->first();
    $toDelete = $sources->slice(1);

    echo "  Keeping ID: {$master->id}, Creating duplicates: " . $toDelete->pluck('id')->join(', ') . "\n";

    foreach ($toDelete as $source) {
        // Move articles to master
        $count = Article::where('source_id', $source->id)->count();
        if ($count > 0) {
            Article::where('source_id', $source->id)->update(['source_id' => $master->id]);
            echo "    Moved {$count} articles from ID {$source->id} to {$master->id}\n";
        }

        // Delete the duplicate source
        $source->delete();
        echo "    Deleted source ID {$source->id}\n";
    }
}

echo "Deduplication complete.\n";

// Check Image stats
$total = Article::count();
$withImage = Article::whereNotNull('image_url')->count();
echo "\nImage Stats:\nTotal Articles: $total\nWith Images: $withImage\n";
