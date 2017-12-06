<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoneyStatistic extends Model
{
	protected $table = 'money_statistics';

	protected $fillable = [
		'money_id',
		'price_usd',
		'price_btc',
		'percent_change_1h',
		'percent_change_24h',
		'percent_change_7d',
		'last_update',
		'market_cap_usd',
		'price_eur',
	];

	public function getMoney()
	{
		return $this->hasOne('App\CryptoMoney', 'id', 'money_id');
	}

}


