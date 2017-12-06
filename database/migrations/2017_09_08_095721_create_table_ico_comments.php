<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableIcoComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('ico_comments', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('ico_id');
		    $table->integer('status_id')->nullable();
		    $table->string('writer_name');
		    $table->string('writer_email');
		    $table->text('content');
		    $table->timestamp('submited_at')->nullable();
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
	    Schema::dropIfExists('ico_comments');
    }
}
