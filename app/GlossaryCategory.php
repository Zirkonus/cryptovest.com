<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GlossaryCategory extends Model
{
    protected $table = "glossary_categories";

    protected $fillable = [
        'name'
    ];

    public function glossaryItem()
    {
        return $this->belongsToMany('App\GlossaryItem', 'glossary_item_category');
    }
}
