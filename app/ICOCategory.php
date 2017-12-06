<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ICOCategory extends Model
{
	protected $table = 'ico_category';

	protected $fillable = [
		'name',
		'is_active',
		'is_other'
	];

	public $timestamps = false;
}
