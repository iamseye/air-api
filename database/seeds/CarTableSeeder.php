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
            'brand' => 'Benz',
            'brand_ch' => '賓士',
            'series' => 'C250',
            'series_model' => '1.2 hteikde',
            'vehicle_type' => '四門房車',
            'year' => 2014
        ]);

        Car::create([
            'brand' => 'Benz',
            'brand_ch' => '賓士',
            'series' => 'C450',
            'series_model' => '1.9 hteikde',
            'vehicle_type' => '四門房車',
            'year' => 2014
        ]);

        Car::create([
            'brand' => 'BMW',
            'brand_ch' => '寶馬',
            'series' => 'Z5',
            'series_model' => '6.9',
            'vehicle_type' => '四門房車',
            'year' => 2013
        ]);

        Car::create([
            'brand' => 'BMW',
            'brand_ch' => '寶馬',
            'series' => 'Z4',
            'series_model' => '6.5',
            'vehicle_type' => '轎車',
            'year' => 2013
        ]);
    }
}
