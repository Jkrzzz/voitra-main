<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActualProcessingTimeEstimatedProcessingTimeToOrdersAudio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders_audio', function (Blueprint $table) {
            $table->double('actual_processing_time')->nullable();
            $table->double('estimated_processing_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders_audio', function (Blueprint $table) {
            $table->dropColumn('actual_processing_time');
            $table->dropColumn('estimated_processing_time');
        });
    }
}
