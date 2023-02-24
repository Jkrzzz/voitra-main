<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RateCommentRateAtCommentAtToOrdersAudioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders_audio', function (Blueprint $table) {
            $table->tinyInteger('rate')->nullable();
            $table->text('comment')->nullable();
            $table->dateTime('rate_at')->nullable();
            $table->dateTime('comment_at')->nullable();
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
            $table->dropColumn('rate');
            $table->dropColumn('comment');
            $table->dropColumn('rate_at');
            $table->dropColumn('comment_at');
        });
    }
}
