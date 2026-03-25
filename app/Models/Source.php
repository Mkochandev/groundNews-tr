<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $fillable = [
        'name',
        'url',
        'rss_url',
        'base_bias',
        'logo'
    ];
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
