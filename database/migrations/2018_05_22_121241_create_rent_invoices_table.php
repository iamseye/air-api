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
            $table->integer('rent_price');
            $table->integer('rent_days');
            $table->integer('pickup_price');
            $table->integer('insurance_price');
            $table->integer('promo_code_discount');
            $table->integer('long_rent_discount');
            $table->integer('emergency_fee');
            $table->integer('total_price');
            $table->string('payment_token')->nullable();
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
