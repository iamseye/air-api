<?php

use Illuminate\Database\Seeder;
use App\Car;

class CarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Car::truncate();

        Car::create([
            'brand' => 'Benz 賓士',
            'series' => 'C',
            'series_model' => 'C250',
            'vehicle_type' => '轎車',
            'year' => 2014
        ]);

        Car::create([
            'brand' => 'BMW 寶馬',
            'series' => 'Z',
            'series_model' => 'Z4',
            'vehicle_type' => '轎車',
            'year' => 2013
        ]);
    }
}
