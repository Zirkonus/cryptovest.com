<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    protected $table = 'coins';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'image',
        'symbol',
        'rank',
        'circulating_supply',
        'total_supply',
        'price_usd',
        'price_btc',
        'volume_btc',
        'change_24',
        'marketcap_usd',
        'website',
        'description_lang_key',
        'link_buy_coin',
    ];

    public function getVolumeBtcAttribute($value)
    {
        return number_format($value, 2);
    }

    public function getTotalSupplyAttribute($value)
    {
        return number_format($value, 2);
    }

    public function getPriceUsdAttribute($value)
    {
        return number_format($value, 2);
    }
}
