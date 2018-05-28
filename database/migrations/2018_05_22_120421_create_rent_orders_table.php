<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('sell_car_id');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('pickup_home_address')->nullable();
            $table->integer('rent_days')->default(0);
            $table->integer('pickup_price')->default(0);
            $table->integer('insurance_price')->default(0);
            $table->integer('promo_code_discount')->default(0);
            $table->integer('long_rent_discount')->default(0);
            $table->integer('emergency_fee')->default(0);
            $table->integer('total_price')->default(0);
            $table->string('order_payment_token')->nullable();
            $table->integer('over_mileage_fee')->default(0);
            $table->integer('bill_fee')->default(0);
            $table->integer('car_park_fee')->default(0);
            $table->integer('ETC')->default(0);
            $table->integer('fuel')->default(0);
            $table->integer('later_return_charge')->default(0);
            $table->string('bill_payment_token')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('rent_orders');
    }
}
