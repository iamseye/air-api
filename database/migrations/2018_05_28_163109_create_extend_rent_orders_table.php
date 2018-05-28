<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtendRentOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extend_rent_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rent_order_id');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('rent_days')->default(0);
            $table->integer('insurance_price')->default(0);
            $table->integer('total_price')->default(0);
            $table->string('order_payment_token')->nullable();
            $table->string('status')->default('UNPAID'); //UNPAID, BOOKED, IN_PROCESS, FINISHED, CANCELED
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
        Schema::dropIfExists('extend_rent_orders');
    }
}
