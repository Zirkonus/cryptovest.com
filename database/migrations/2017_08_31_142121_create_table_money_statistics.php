<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMoneyStatistics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('money_statistics', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('money_id');
		    $table->float('price_usd' );
		    $table->double('price_btc');
		    $table->float('percent_change_1h');
		    $table->float('percent_change_24h');
		    $table->float('percent_change_7d');
		    $table->unsignedBigInteger('last_update');
		    $table->unsignedBigInteger('market_cap_usd');
		    $table->double('price_eur');
		    $table->timestamps();
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::dropIfExists('money_statistics');
    }
}
