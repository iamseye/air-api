<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVerifyColumnsUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_email_verified')->default(false);
            $table->boolean('is_phone_verified')->default(false);
            $table->boolean('is_ID_card_verified')->default(false);
            $table->boolean('is_driver_license_verified')->default(false);
            $table->boolean('is_photo_verified')->default(false);
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
            $table->dropColumn(['is_email_verified']);
            $table->dropColumn(['is_phone_verified']);
            $table->dropColumn(['is_ID_card_verified']);
            $table->dropColumn(['is_driver_license_verified']);
            $table->dropColumn(['is_photo_verified']);
        });
    }
}
