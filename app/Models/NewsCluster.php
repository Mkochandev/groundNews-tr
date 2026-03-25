<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewsCluster extends Model
{
    protected $fillable = [
        'title',
        'image_url',
        'summary',
        'summary_left',
        'summary_center',
        'summary_right',
        'bias_data',
        'bias_distribution',
        'analysis_status',
        'analysis_text',
        'bias_left',
        'bias_center',
        'bias_right',
        'is_analyzed',
        'category',
        'source_count',
    ];

    protected $casts = [
        'is_analyzed' => 'boolean',
        'bias_data' => 'json',
        'bias_distribution' => 'json',
        'bias_left' => 'integer',
        'bias_center' => 'integer',
        'bias_right' => 'integer',
        'source_count' => 'integer',
    ];

    /**
     * Cluster'a ait haberler (articles tablosu oluşturulduğunda aktif edilebilir)
     */
    public function articles(): HasMany
    {
        // return $this->hasMany(Article::class, 'cluster_id');
        return $this->hasMany(Article::class); // Şimdilik placeholder
    }
}

