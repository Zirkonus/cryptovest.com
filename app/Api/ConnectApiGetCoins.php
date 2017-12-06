<?php

namespace App\Api;

class ConnectApiGetCoins
{
    /**
     * Get coins API
     *
     * @return array|bool
     */
    public static function getCoins()
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://cryptocoincharts.info/cl_apis/cryptovest.php?w=crypto&key=ds92ncmas02_1adsmdssa0d93k61a32gcfd21');
        $coinsList = json_decode($res->getBody(), true);

        if ($res->getStatusCode() == '200') {
            return $coinsList;
        } else {
            return false;
        }
    }
}