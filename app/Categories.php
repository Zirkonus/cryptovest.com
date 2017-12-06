<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name_lang_key',
        'description_lang_key',
        'friendly_url',
        'is_active',
        'is_menu',
        'parent_id',
	    'full_url'
    ];

    public function getMetaContent()
    {
    	return $this->hasMany('App\MetaContentForCategory', 'category_id');
    }

    public function getPosts()
    {
    	return $this->hasMany('App\Post','category_id');
    }

    public function getParentCateg()
    {
    	return $this->hasOne('App\Categories', 'id', 'parent_id');
    }

    public function getChildrens()
    {
    	return $this->hasMany('App\Categories', 'parent_id');
    }
}
