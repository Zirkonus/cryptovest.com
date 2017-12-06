<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_lang_key')->nullable();
            $table->string('description_lang_key')->nullable();
            $table->string('friendly_url')->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->tinyInteger('is_menu')->default(0);
            $table->integer('parent_id')->nullable();
            $table->string('full_url')->nullable();
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
        Schema::dropIfExists('categories');
    }
}
