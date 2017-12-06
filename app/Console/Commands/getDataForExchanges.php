<?php

namespace App\Console\Commands;

use App\Api\ConnectApi;
use App\Api\ConnectApiGetExchanges;
use App\Exchange;
use Illuminate\Console\Command;

class getDataForExchanges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get-exchanges-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $exchangesList = ConnectApiGetExchanges::getExchanges();

        if ($exchangesList) {

            /* Remove all exchanges which not in array */
            $exchangesName = [];
            foreach ($exchangesList as $exchanges) {
                $exchangesName[] = $exchanges['name'];
            }
            Exchange::whereNotIn('name', $exchangesName)->delete();

            foreach ($exchangesList as $value) {

                $exchangeNew = false;

                $exchange = Exchange::where('name', $value['name'])->first();

                if (!$exchange) {
                    $exchange = new Exchange();
                }

                $exchange->name = $value['name'];
                $exchange->website = $value['website'];
                $exchange->last_update_gmt = $value['last_update_gmt'];
                $exchange->trading_pairs = $value['trading_pairs'];
                $exchange->volume_btc = doubleval($value['volume_btc']);
                $exchange->volume_usd = doubleval($value['volume_usd']);
                $exchange->volume_eur = doubleval($value['volume_eur']);
                $exchange->volume_cny = doubleval($value['volume_cny']);
                $exchange->volume_aud = doubleval($value['volume_aud']);
                $exchange->volume_hkd = doubleval($value['volume_hkd']);
                $exchange->volume_cad = doubleval($value['volume_cad']);
                $exchange->volume_krw = doubleval($value['volume_krw']);
                $exchange->volume_rur = doubleval($value['volume_rur']);
                $exchange->volume_uah = doubleval($value['volume_uah']);

                if ($exchange->isDirty()) {
                    $exchange->save();
                }
            }
        }
    }
}
