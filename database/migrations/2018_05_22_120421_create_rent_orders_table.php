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
            $table->unsignedInteger('rent_invoice_id');
            $table->unsignedInteger('rent_extend_invoice_id');
            $table->boolean(' is_pickup_at_car_center')->default(false);
            $table->string('pickup_home_city')->nullable();
            $table->string('pickup_home_area')->nullable();
            $table->string('pickup_home_address')->nullable();
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->datetime('pickup_time');
            $table->text('remarks')->nullable();
            $table->string('status')->default('BOOKED'); //BOOKED, IN_PROCESS, FINISHED, CANCELED
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
