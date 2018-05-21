<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_seller')->default(false);
            $table->integer('wallet_amount')->default(0);
            $table->string('driver_license', 15)->nullable();
            $table->string('ID_number', 10)->nullable();
            $table->date('birth')->nullable();
            $table->tinyInteger('gender')->default(0);
            $table->string('address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_seller']);
            $table->dropColumn(['wallet_amount']);
            $table->dropColumn(['driver_license']);
            $table->dropColumn(['ID_number']);
            $table->dropColumn('birth');
            $table->dropColumn('gender');
            $table->dropColumn('address');
        });
    }
}


