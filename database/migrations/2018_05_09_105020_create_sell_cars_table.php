<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_cars', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('seller_id');
            $table->unsignedInteger('car_id');
            $table->unsignedInteger('car_center_id');
            $table->unsignedInteger('sell_car_examination_id')->nullable();
            $table->string('accessories')->nullable();
            $table->text('description');
            $table->integer('buy_price');
            $table->integer('rent_price');
            $table->dateTime('available_from');
            $table->dateTime('available_to');
            $table->text('remarks')->nullable();
            $table->boolean('active')->default(false);
            $table->boolean('is_sold')->default(false);
            $table->string('class')->nullable();
            $table->integer('mileage')->nullable();
            $table->dateTime('examination_date')->nullable();
            $table->text('examination_remark')->nullable();

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
        Schema::dropIfExists('sell_cars');
    }
}
