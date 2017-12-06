<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_lang_key')->nullable();
            $table->string('title_main_block_lang_key')->nullable();
            $table->string('title_first_block_lang_key')->nullable();
            $table->string('text_first_block_lang_key')->nullable();
	        $table->string('title_second_block_lang_key')->nullable();
	        $table->string('text_second_block_lang_key')->nullable();
	        $table->string('reserve_text_block_lang_key')->nullable();
            $table->string('description_lang_key')->nullable();
            $table->string('friendly_url')->nullable();
            $table->string('page_image')->nullable();
            $table->string('content_lang_key')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
