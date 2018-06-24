<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellCarExaminationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_car_examinations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sell_car_id');
            $table->string('class');
            $table->integer('mileage');
            $table->dateTime('examination_date');
            $table->boolean('ACC_1')->default(false);
            $table->boolean('ACC_2')->default(false);
            $table->boolean('SYS_1')->default(false);
            $table->boolean('SYS_2')->default(false);
            $table->boolean('LOOK_1')->default(false);
            $table->boolean('LOOK_2')->default(false);
            $table->boolean('ALL_1')->default(false);
            $table->boolean('ALL_2')->default(false);
            $table->boolean('ALL_3')->default(false);
            $table->boolean('ALL_4')->default(false);
            $table->boolean('ALL_5')->default(false);
            $table->boolean('ALL_6')->default(false);
            $table->boolean('ALL_7')->default(false);
            $table->boolean('ALL_8')->default(false);
            $table->boolean('ALL_9')->default(false);
            $table->boolean('ALL_1_URL')->nullable();
            $table->boolean('ALL_2_URL')->nullable();
            $table->boolean('ALL_3_URL')->nullable();
            $table->boolean('ALL_4_URL')->nullable();
            $table->boolean('ALL_5_URL')->nullable();
            $table->boolean('ALL_6_URL')->nullable();
            $table->boolean('ALL_7_URL')->nullable();
            $table->boolean('ALL_8_URL')->nullable();
            $table->boolean('ALL_9_URL')->nullable();
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
        Schema::dropIfExists('sell_car_examinations');
    }
}
