<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIcoCommentsTableAddIp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ico_comments', function (Blueprint $table) {
            $table->string('ip')->default('')->after('submited_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ico_comments', function (Blueprint $table) {
            $table->string('ip')->default('')->after('submited_at');
        });
    }
}
