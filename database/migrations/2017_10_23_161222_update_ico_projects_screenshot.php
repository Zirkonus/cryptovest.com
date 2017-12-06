<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIcoProjectsScreenshot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ico_projects', function (Blueprint $table) {
            $table->string('ico_screenshot')->nullable()->after('ico_category_other');

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
            $table->dropColumn('ico_screenshot');
        });
    }
}
