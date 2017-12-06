<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';

    protected $fillable = [
        'title_lang_key',
        'description_lang_key',
        'friendly_url',
        'page_image',
        'content_lang_key',

        'title_main_block_lang_key',
        'title_first_block_lang_key',
        'text_first_block_lang_key',
	    'title_second_block_lang_key',
	    'text_second_block_lang_key',
        'reserve_text_block_lang_key',
    ];

    public $timestamps = false;

	public function getMetaContent ()
	{
		return $this->hasMany('App\MetaContentForPage');
	}
}
