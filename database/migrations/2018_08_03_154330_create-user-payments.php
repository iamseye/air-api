<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->integer('status');
            $table->string('msg');
            $table->string('rec_trade_id');
            $table->string('bank_transaction_id');
            $table->string('auth_code');
            $table->integer('amount');
            $table->string('currency');
            $table->string('order_number');
            $table->string('bin_code');
            $table->string('last_four');
            $table->string('issuer');

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
        Schema::dropIfExists('user_payments');
    }
}
