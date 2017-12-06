<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMetaContentForCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('meta_content_for_categories', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('language_id');
		    $table->integer('meta_type_id');
		    $table->integer('category_id');
		    $table->string('content');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::dropIfExists('meta_content_for_categories');
    }
}
