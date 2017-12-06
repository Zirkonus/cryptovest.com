<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoinValue extends Model
{
    protected $table = 'coins_values';

    protected $fillable = [
        'key_coin',
        'value_image',
        'value_link_buy_coin'
    ];

    public $timestamps = false;

    static private $coinValues = null;
    static private $linkBuyCoinValues = null;

    public static function getValueImage($key)
    {
        if (!isset(self::$coinValues)) {
            self::$coinValues = self::get()->pluck('value_image', 'key_coin');
        }

        $value = self::$coinValues[$key] ?? null;

        if ($value) {
            return $value;
        }
    }

    public static function getLinkBuyCoin($key)
    {
        if (!isset(self::$linkBuyCoinValues)) {
            self::$linkBuyCoinValues = self::get()->pluck('value_link_buy_coin', 'key_coin');
        }

        $value = self::$linkBuyCoinValues[$key] ?? null;

        if ($value) {
            return $value;
        }
    }
}
