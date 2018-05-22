<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('insurance_id');
            $table->unsignedInteger('promo_code_id');
            $table->integer('rent_price');
            $table->integer('rent_days');
            $table->integer('discount');
            $table->integer('total_price');
            $table->unsignedInteger('payment_id')->nullable(); //if using bind payment
            $table->string('payment_name')->nullable();
            $table->string('payment_account')->nullable();
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
        Schema::dropIfExists('rent_invoices');
    }
}
