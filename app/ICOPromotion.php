<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ICOPromotion extends Model
{
	protected $table = 'ico_promotion';

	protected $fillable = [
		'name',
		'icon',
		'is_active',
	];

	public $timestamps = false;
}
