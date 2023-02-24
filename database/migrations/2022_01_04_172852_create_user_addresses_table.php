<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('type');
            $table->unsignedBigInteger('user_id');
            $table->string('full_name');
            $table->string('full_kana_name')->nullable();
            $table->string('company_name')->nullable();
            $table->string('department_name')->nullable();
            $table->string('tel');
            $table->string('mobile')->nullable();
            $table->string('zipcode');
            $table->string('address1');
            $table->string('address2');
            $table->string('address3');
            $table->string('email');
            $table->string('details')->nullable();
            $table->boolean('default')->default(false);
            $table->boolean('public')->default(true);
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
        Schema::dropIfExists('user_addresses');
    }
}
