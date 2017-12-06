<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    protected $table = 'exchanges';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'website',
        'last_update_gmt',
        'trading_pairs',
        'volume_btc',
        'volume_usd',
        'volume_eur',
        'volume_cny',
        'volume_aud',
        'volume_hkd',
        'volume_cad',
        'volume_krw',
        'volume_rur',
        'volume_uah',
    ];
}
