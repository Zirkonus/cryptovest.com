<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableContactForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('contact_form', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('first_name');
		    $table->string('last_name');
		    $table->string('company');
		    $table->string('email');
		    $table->string('phone');
		    $table->text('post_content' );
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
	    Schema::dropIfExists('contact_form');
    }
}
