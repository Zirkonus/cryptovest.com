<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetaContentForPost extends Model
{
    const TYPE_KEYWORD = 3;

    protected $table = 'meta_content_for_posts';

    protected $fillable = [
        'language_id',
        'meta_type_id',
        'post_id',
        'content'
    ];

    public $timestamps = false;


    public function post()
    {
        return $this->hasOne('App\User', 'id', 'post_id');
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getPostId()
    {
        return $this->post_id;
    }

    public function scopeKeywordType($query)
    {
        return $query->where('meta_type_id', self::TYPE_KEYWORD);
    }
}
