<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableIcoMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('ico_members', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('ico_id');
		    $table->string('first_name');
		    $table->string('last_name');
		    $table->string('position');
		    $table->string('twitter_link')->nullable();
		    $table->string('linkedin_link')->nullable();
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
	    Schema::dropIfExists('ico_members');
    }
}
