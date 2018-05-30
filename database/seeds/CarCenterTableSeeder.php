<?php

use Illuminate\Database\Seeder;
use App\CarCenter;

class CarCenterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's clear the users table first
        CarCenter::truncate();

        $faker = \Faker\Factory::create();

        // Let's make sure everyone has the same password and
        // let's hash it before the loop, or else our seeder
        // will be too slow.
        //$password = Hash::make('toptal');

        CarCenter::create([
            'name' => '交車站1',
            'area' => '台中',
            'phone_number' => $faker->phoneNumber,
            'address' => '台中市正氣街52號'
        ]);

        CarCenter::create([
            'name' => '交車站2',
            'area' => '台北',
            'phone_number' => $faker->phoneNumber,
            'address' => $faker->address
        ]);
    }
}
