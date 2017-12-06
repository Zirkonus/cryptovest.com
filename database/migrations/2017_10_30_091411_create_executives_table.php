<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExecutivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('executives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name_lang_key')->nullable();
            $table->string('last_name_lang_key')->nullable();
            $table->string('email')->unique();
            $table->string('url')->unique();
            $table->string('profile_image')->nullable();
            $table->string('biography_lang_key')->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->timestamps();
        });

        Schema::create('post_executive', function (Blueprint $table) {
            $table->integer('post_id');
            $table->integer('executive_id');
            $table->primary(['post_id', 'executive_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_executive');
        Schema::dropIfExists('executives');
    }
}
