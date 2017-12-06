<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLanguages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('country_code');
            $table->string('language_code');
            $table->string('name')->unique();
            $table->tinyInteger('is_active')->default(0);
            $table->tinyInteger('is_english')->default(0);
            $table->tinyInteger('is_main')->default(0);
            $table->unique(['country_code', 'language_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
