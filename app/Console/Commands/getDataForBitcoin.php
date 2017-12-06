<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App;
use App\Api\ConnectApi;
use App\CryptoMoney;
use App\MoneyStatistic;

class getDataForBitcoin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get-bitcoins-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data from coinmarketcap.com site';

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
    	$connect = new ConnectApi();

    	$data = $connect->getDate();

	    if ($data) {
		    foreach ($data as $value) {
			    $money = CryptoMoney::where('name', $value->name)->first();
			    if (!$money) {
				    $money = CryptoMoney::create([
					    'name'      => $value->name,
					    'symbol'    => $value->symbol,
				    ]);
			    }
			    MoneyStatistic::create([
				    'money_id'              => $money->id,
				    'price_usd'             => $value->price_usd,
				    'price_btc'             => $value->price_btc,
				    'percent_change_1h'     => $value->percent_change_1h,
				    'percent_change_24h'    => $value->percent_change_24h,
				    'percent_change_7d'     => $value->percent_change_7d,
				    'last_update'           => $value->last_updated,
				    'market_cap_usd'        => intval($value->market_cap_usd),
				    'price_eur'             => $value->price_eur,
			    ]);
		    }

		    $bitcoinDat = MoneyStatistic::where('money_id', 1)->select('percent_change_7d')->orderBy('created_at', 'desc')->limit(10080)->get()->nth(100)->reverse();
		    $script = "var dataForApiGraf = [";
		    $i = 1;

		    foreach ($bitcoinDat as $b) {
			    $script .= "{ \"point\": $i, \"value\": ";
			    $val = $b->percent_change_7d * 100;
			    $script .= "$val },";
			    $i++;
		    }
		    $script .= "];";
		    $fileName= storage_path("app/public/js/api-data.js");
		    file_put_contents($fileName, $script);

	    } else {
	    	echo 'Connection error';
	    }
    }
}
