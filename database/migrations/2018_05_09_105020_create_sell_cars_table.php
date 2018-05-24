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
            $table->string('accessories')->nullable();
            $table->text('description');
            $table->integer('buy_price');
            $table->integer('rent_price');
            $table->date('available_from');
            $table->date('available_to');
            $table->text('remarks')->nullable();
            $table->boolean('active')->default(false);
            $table->boolean('is_sold')->default(false);
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
