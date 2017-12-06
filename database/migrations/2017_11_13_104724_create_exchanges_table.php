<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchanges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('website');
            $table->dateTime('last_update_gmt');
            $table->text('trading_pairs');
            $table->double('volume_btc');
            $table->double('volume_usd');
            $table->double('volume_eur');
            $table->double('volume_cny');
            $table->double('volume_aud');
            $table->double('volume_hkd');
            $table->double('volume_cad');
            $table->double('volume_krw');
            $table->double('volume_rur');
            $table->double('volume_uah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchanges');
    }
}
