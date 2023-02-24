<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSettingParams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('setting_params', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('expired_date')->datetime();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('setting_params', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('expired_date');
        });
    }
}
