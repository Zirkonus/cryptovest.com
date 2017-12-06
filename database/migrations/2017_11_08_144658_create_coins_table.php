<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('symbol');
            $table->integer('rank');
            $table->unsignedBigInteger('circulating_supply');
            $table->unsignedBigInteger('total_supply');
            $table->float('price_usd');
            $table->double('price_btc');
            $table->double('volume_btc');
            $table->double('change_24');
            $table->double('marketcap_usd');
            $table->string('website');
            $table->string('description_lang_key')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coins');
    }
}
