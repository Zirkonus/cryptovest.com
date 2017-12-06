<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIcoDealsChangeId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ico_deals', function (Blueprint $table) {
            $table->integer('ico_buyer_id')->default(0)->change();
            $table->integer('ico_projects_id')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ico_deals', function (Blueprint $table) {
            $table->integer('ico_buyer_id')->change();
            $table->integer('ico_projects_id')->change();
        });
    }
}
