<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('start_at');
            $table->date('end_at');
            $table->string('code');
            $table->bigInteger('quantity')->nullable();
            $table->bigInteger('used_quantity')->default(0);
            $table->double('discount_amount');
            $table->tinyInteger('is_limited');
            $table->tinyInteger('is_private');
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
