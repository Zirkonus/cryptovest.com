<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIcoProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ico_projects', function (Blueprint $table) {
            $table->string('ico_platform_other')->nullable()->after('ico_screenshot');
            $table->string('ico_category_other')->nullable()->after('ico_platform_other');
            $table->string('short_token')->nullable()->after('total_supply');
            $table->string('number_coins')->nullable()->after('short_token');
            $table->integer('ico_platform_id')->nullable()->change();
            $table->integer('ico_category_id')->nullable()->change();
            $table->integer('ico_project_type_id')->nullable()->change();

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
            $table->dropColumn('ico_platform_other');
            $table->dropColumn('ico_category_other');
        });
    }
}
