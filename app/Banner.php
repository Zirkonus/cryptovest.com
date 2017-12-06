<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banners';

    protected $fillable = [
        'title_lang_key',
        'url',
        'image',
        'views_count',
        'clicks_count',
        'is_active'
    ];

    public $timestamps = false;
}
