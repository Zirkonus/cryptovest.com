<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetaContentForCategory extends Model
{
    protected $table = 'meta_content_for_categories';

    protected $fillable = [
        'language_id',
        'meta_type_id',
        'category_id',
        'content'
    ];

    public $timestamps = false;
}
