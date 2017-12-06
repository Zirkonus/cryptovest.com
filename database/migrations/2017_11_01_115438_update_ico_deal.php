<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIcoDeal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ico_deals', function (Blueprint $table) {
            $table->string('ip_address')->default(0)->after('total_coast');
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
            $table->dropColumn('ip_address');
        });
    }
}
