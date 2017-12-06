<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ICOMoney extends Model
{
	protected $table = 'ico_money';

	protected $fillable = [
		'name',
		'icon',
		'is_active',
	];

	public $timestamps = false;
}
