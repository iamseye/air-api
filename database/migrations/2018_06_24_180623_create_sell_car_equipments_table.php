<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellCarEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_car_equipments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sell_car_id');
            $table->boolean('OUT_1')->default(false);
            $table->boolean('OUT_2')->default(false);
            $table->boolean('OUT_3')->default(false);
            $table->boolean('OUT_4')->default(false);
            $table->boolean('OUT_5')->default(false);
            $table->boolean('OUT_6')->default(false);
            $table->boolean('OUT_7')->default(false);
            $table->boolean('OUT_8')->default(false);
            $table->boolean('OUT_9')->default(false);
            $table->boolean('OUT_10')->default(false);
            $table->boolean('IN_1')->default(false);
            $table->boolean('IN_2')->default(false);
            $table->boolean('IN_3')->default(false);
            $table->boolean('IN_4')->default(false);
            $table->boolean('IN_5')->default(false);
            $table->boolean('IN_6')->default(false);
            $table->boolean('IN_7')->default(false);
            $table->boolean('IN_8')->default(false);
            $table->boolean('IN_9')->default(false);
            $table->boolean('IN_10')->default(false);
            $table->boolean('S_1')->default(false);
            $table->boolean('S_2')->default(false);
            $table->boolean('S_3')->default(false);
            $table->boolean('S_4')->default(false);
            $table->boolean('S_5')->default(false);
            $table->boolean('S_6')->default(false);
            $table->boolean('S_7')->default(false);
            $table->text('review')->nullable();

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
        Schema::dropIfExists('sell_car_equipments');
    }
}
