<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ICOProjectMoney extends Model
{
	protected $table = 'icoprojects_money';

	protected $fillable = [
		'ico_id',
		'money_id',
	];

	public $timestamps = false;
}
