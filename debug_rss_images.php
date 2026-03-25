<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\Http;

function extractImageFromItem($item)
{
    // 1. media:content
    $media = $item->children('http://search.yahoo.com/mrss/');
    if (isset($media->content)) {
        $attr = $media->content->attributes();
        if (isset($attr['url']))
            return (string) $attr['url'] . " (media:content)";
    }

    if (isset($media->thumbnail)) {
        $attr = $media->thumbnail->attributes();
        if (isset($attr['url']))
            return (string) $attr['url'] . " (media:thumbnail)";
    }

    // 2. enclosure
    if (isset($item->enclosure)) {
        $attr = $item->enclosure->attributes();
        if (isset($attr['url']))
            return (string) $attr['url'] . " (enclosure)";
    }

    // 3. description img
    $desc = (string) $item->description;
    if (preg_match('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $desc, $matches)) {
        return $matches[1] . " (description)";
    }

    return "NO IMAGE";
}

$url = 'https://www.haberturk.com/rss';
echo "Fetching $url...\n";

$response = file_get_contents($url);
$rss = simplexml_load_string($response);

foreach ($rss->channel->item as $item) {
    echo "Title: " . $item->title . "\n";
    echo "Image: " . extractImageFromItem($item) . "\n";
    echo "---\n";
}
