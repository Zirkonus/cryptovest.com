<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriesPosts extends Model
{
    protected $table = 'categories_posts';

    protected $fillable = [
        'category_id',
        'post_id'
    ];

    public $timestamps = false;
}
