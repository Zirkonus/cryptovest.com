<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ICOPlatform extends Model
{
	protected $table = 'ico_platform';

	protected $fillable = [
		'name',
		'icon',
		'is_active',
		'is_other'
	];

	public $timestamps = false;
}
