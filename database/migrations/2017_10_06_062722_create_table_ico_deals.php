<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableIcoDeals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ico_deals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('buyer_id');
            $table->integer('ico_id');
            $table->integer('payment_type_id');
            $table->string('payment_option')->nullable();
            $table->string('total_coast');
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
        Schema::dropIfExists('ico_deals');
    }
}
