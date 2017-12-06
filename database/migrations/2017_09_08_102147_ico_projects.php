<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IcoProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ico_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ico_category_id')->nullable();
            $table->integer('ico_platform_id')->nullable();
            $table->integer('ico_project_type_id')->nullable();
            $table->integer('ico_promotion_id')->default(10);

            $table->string('title');
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('friendly_url');
            $table->text('image')->nullable();
            $table->text('presale_condition')->nullable();
            $table->text('total_supply')->nullable();

            $table->string('short_token')->nullable();
            $table->string('number_coins')->nullable();

            $table->timestamp('data_start')->nullable();
            $table->timestamp('data_end')->nullable();

            $table->string('link_whitepaper')->nullable();
            $table->string('link_announcement')->nullable();
            $table->string('link_youtube')->nullable();
            $table->string('link_facebook')->nullable();
            $table->string('link_telegram')->nullable();
            $table->string('link_instagram')->nullable();
            $table->string('link_website')->nullable();

            $table->string('link_linkedin')->nullable();
            $table->string('link_twitter')->nullable();
            $table->string('link_slack')->nullable();
            $table->string('link_but_join_presale')->nullable();
            $table->string('link_but_explore_more')->nullable();
            $table->string('link_but_join_token_sale')->nullable();
            $table->string('link_but_exchange')->nullable();

            $table->tinyInteger('is_widget')->default(0);
            $table->tinyInteger('is_top')->default(0);
            $table->tinyInteger('is_active')->default(0);

            $table->string('ico_platform_other')->nullable();
            $table->string('ico_category_other')->nullable();
            $table->text('ico_screenshot')->nullable();

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
        Schema::dropIfExists('ico_projects');
    }
}
