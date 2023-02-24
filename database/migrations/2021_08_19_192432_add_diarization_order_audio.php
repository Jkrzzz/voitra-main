<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiarizationOrderAudio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders_audio', function (Blueprint $table) {
            $table->boolean('diarization')->nullable();
            $table->integer('num_speaker')->nullable();
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
            $table->dropColumn('diarization');
            $table->dropColumn('num_speaker');
        });
    }
}
