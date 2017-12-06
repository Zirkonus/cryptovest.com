<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CryptoMoney extends Model
{
	protected $table = 'crypto-money';

	protected $fillable = [
		'name',
		'symbol',
	];

	public function getStatistic()
	{
		return $this->hasMany('App\MoneyStatistic', 'money_id', 'id');
	}

}
