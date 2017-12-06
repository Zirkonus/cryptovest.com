<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableIcoMoney extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('ico_money', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('name');
		    $table->string('icon')->nullable();
		    $table->tinyInteger('is_active')->default(0);
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::dropIfExists('ico_money');
    }
}
