<?php

namespace App\Api;

class ConnectApiGetExchanges
{
    /**
     * Get exchanges API
     *
     * @return array|bool
     */
    public static function getExchanges()
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://cryptocoincharts.info/cl_apis/cryptovest.php?w=exchanges&key=ds92ncmas02_1adsmdssa0d93k61a32gcfd21');
        $exchangesList = json_decode($res->getBody(), true);

//        if ($res->getStatusCode() == '200') {
//            return $exchangesList;
//        } else {
//            return false;
//        }

        // Temporary
        return false;
    }
}