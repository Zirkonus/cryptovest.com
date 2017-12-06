<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIcoProjectsTopSix extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ico_projects', function (Blueprint $table) {
            $table->tinyInteger('is_top_six')->default(0)->after('is_fraud');
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
            $table->dropColumn('is_top_six');
        });
    }
}
