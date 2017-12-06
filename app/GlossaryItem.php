<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GlossaryItem extends Model
{
    protected $table = "glossary_items";

    protected $fillable = [
        'title',
        'content'
    ];

    public function glossaryCategory()
    {
        return $this->belongsToMany('App\GlossaryCategory', 'glossary_item_category');
    }
}
