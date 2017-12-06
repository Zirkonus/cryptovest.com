<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetaContentForPage extends Model
{
    protected $table = 'meta_content_for_pages';

    protected $fillable = [
        'language_id',
        'meta_type_id',
        'page_id',
        'content'
    ];

    public $timestamps = false;
}
