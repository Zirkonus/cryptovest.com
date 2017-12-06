<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
	protected $table = 'subscribers';

	protected $fillable = [
		'name',
		'email',
		'ip',
	];

	public function getCategories()
	{
		return $this->belongsToMany('App\Categories', 'subscribers_categories',  'subscriber_id', 'category_id');
	}

	public function is_news()
	{

	}
}
