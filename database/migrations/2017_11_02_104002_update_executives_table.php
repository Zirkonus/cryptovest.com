<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateExecutivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('executives', function (Blueprint $table) {
            $table->integer('country_id')->default(0)->after('email');
            $table->string('twitter_link')->nullable()->after('country_id');
            $table->string('linkedin_link')->nullable()->after('twitter_link');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('executives', function (Blueprint $table) {
            $table->dropColumn('country_id');
            $table->dropColumn('twitter_link');
            $table->dropColumn('linkedin_link');
        });
    }
}
