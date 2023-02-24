<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAudioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audio', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->text('edited_result')->nullable();
            $table->string('language')->nullable();
            $table->double('duration')->nullable();
            $table->double('price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audio', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('edited_result');
            $table->dropColumn('language');
            $table->dropColumn('duration');
            $table->dropColumn('price');
        });
    }
}
