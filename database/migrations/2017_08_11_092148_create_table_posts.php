<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('category_id');
            $table->integer('status_id')->default(0);
            $table->string('friendly_url')->nullable();
            $table->string('title_lang_key')->nullable();
            $table->string('title_image')->nullable();
            $table->string('short_image')->nullable();
            $table->string('category_image')->nullable();
            $table->string('description_lang_key')->nullable();
            $table->string('content_lang_key')->nullable();
            $table->tinyInteger('is_keep_featured')->default(0);
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
        Schema::dropIfExists('posts');
    }
}
