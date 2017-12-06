<?php

namespace App\Console\Commands;

use App\Api\ConnectApi;
use App\Api\ConnectApiGetCoins;
use App\Coin;
use Illuminate\Console\Command;

class getDataForCoins extends Command
{
    /**
     * Get coins data
     *
     * @var string
     */
    protected $signature = 'get-coins-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data from cryptocoincharts.info site';

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
        $this->info('cron started');

        $coinsList = ConnectApiGetCoins::getCoins();

        if ($coinsList) {

            /* Remove all coins which not in array */
            $coinsSymbol = [];
            foreach ($coinsList as $coin) {
                $coinsSymbol[] = $coin['symbol'];
            }
            Coin::whereNotIn('symbol', $coinsSymbol)->delete();

            foreach ($coinsList as $value) {

                $coinNew = false;

                $coin = Coin::where('symbol', $value['symbol'])->first();

                if (!$coin) {
                    $coin = new Coin();
                    $coinNew = true;
                }

                $coin->name = $value['name'];
                $coin->symbol = $value['symbol'];
                $coin->rank = $value['rank'];
                $coin->circulating_supply = intval($value['circulating_supply']);
                $coin->total_supply = intval($value['total_supply']);
                $coin->price_usd = doubleval(str_replace("$", "", $value['price_usd']));
                $coin->price_btc = doubleval($value['price_btc']);
                $coin->volume_btc = doubleval($value['volume_btc']);
                $coin->change_24 = doubleval(str_replace("%", "", $value['change_24']));
                $coin->marketcap_usd = doubleval(str_replace("$", "", $value['marketcap_usd']));
                $coin->website = $value['website'];

                if ($coin->isDirty()) {
                    $coin->save();

                    if ($coinNew) {
                        $coin->description_lang_key = 'description-coins_' . $coin->symbol;
                        $coin->slug = str_slug($coin->symbol);
                        $coin->save();
                    }
                }

            }
        }
    }
}
