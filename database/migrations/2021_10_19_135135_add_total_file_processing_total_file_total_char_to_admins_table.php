<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalFileProcessingTotalFileTotalCharToAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->integer('total_order')->default(0);
            $table->integer('total_order_processing')->default(0);
            $table->integer('total_char_processing')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('total_order');
            $table->dropColumn('total_order_processing');
            $table->dropColumn('total_char_processing');
        });
    }
}
