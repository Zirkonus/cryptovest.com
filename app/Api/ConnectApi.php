<?php

namespace App\Api;

class ConnectApi
{
    public function getDate()
    {
        $url = 'https://api.coinmarketcap.com/v1/ticker/?convert=EUR&limit=4';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);

        $obj = json_decode($result);
        return $obj;
    }

    public function getBitcoin()
    {
        $url = 'https://api.coinmarketcap.com/v1/ticker/bitcoin/?convert=EUR';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);

        $obj = json_decode($result);
        return $obj;
    }
}