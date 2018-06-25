<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInSellCarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sell_cars', function (Blueprint $table) {
            $table->string('outside_color');
            $table->string('inside_color');
            $table->integer('displacement');
            $table->string('shift_system');
            $table->string('fuel');
            $table->integer('door_number');
            $table->integer('passenger_number');
            $table->string('driven_method');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sell_cars', function (Blueprint $table) {
            $table->dropColumn('outside_color');
            $table->dropColumn('inside_color');
            $table->dropColumn('displacement');
            $table->dropColumn('shift_system');
            $table->dropColumn('fuel');
            $table->dropColumn('door_number');
            $table->dropColumn('passenger_number');
            $table->dropColumn('driven_method');
        });
    }
}
