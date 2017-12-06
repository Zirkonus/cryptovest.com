<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIcoProjectsIcoBuyer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ico_projects', function (Blueprint $table) {
            $table->integer('ico_deal_id')->nullable()->after('ico_screenshot');
            $table->string('title')->nullable()->change();
            $table->string('friendly_url')->nullable()->change();
            $table->text('short_description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ico_projects', function (Blueprint $table) {
            $table->dropColumn('ico_deal_id');
            $table->string('title')->change();
            $table->string('friendly_url')->change();
            $table->text('short_description')->change();
        });
    }
}