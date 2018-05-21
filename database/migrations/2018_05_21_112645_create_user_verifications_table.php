<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_verifications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->unsigned()->nullable();
            $table->boolean('is_email_verified')->default(false);
            $table->boolean('is_phone_verified')->default(false);
            $table->boolean('is_ID_card_verified')->default(false);
            $table->boolean('is_driver_license_verified')->default(false);
            $table->boolean('is_photo_verified')->default(false);
            $table->string('ID_card_photo')->nullable();
            $table->string('driver_license_photo')->nullable();
            $table->string('personal_photo')->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_verifications');
    }
}
