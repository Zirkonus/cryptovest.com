<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIcoBuyer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ico_buyers', function (Blueprint $table) {
            $table->string('company')->nullable()->change();
            $table->string('mobile')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ico_buyers', function (Blueprint $table) {
            $table->string('company')->change();
            $table->string('mobile')->change();
        });
    }
}
