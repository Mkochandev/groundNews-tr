<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    // BU KISIM VERİTABANINA YAZMA İZNİ VERİR (Çok Önemli!)
    protected $fillable = [
        'source_id',
        'title',
        'url',
        'description',
        'published_at',
        'is_analyzed',
        'news_cluster_id',
        'image_url',
    ];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function cluster()
    {
        return $this->belongsTo(NewsCluster::class, 'news_cluster_id');
    }
}