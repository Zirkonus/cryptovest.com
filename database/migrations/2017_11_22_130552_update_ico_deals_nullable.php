<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIcoDealsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ico_deals', function (Blueprint $table) {
            $table->renameColumn('buyer_id', 'ico_buyer_id');
            $table->renameColumn('ico_id', 'ico_projects_id');
            $table->integer('payment_type_id')->default(0)->change();
            $table->string('total_coast')->nullable()->change();
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
            $table->renameColumn('ico_buyer_id', 'buyer_id');
            $table->renameColumn('ico_projects_id', 'ico_id');
            $table->integer('payment_type_id')->change();
            $table->string('total_coast')->change();
        });
    }
}
