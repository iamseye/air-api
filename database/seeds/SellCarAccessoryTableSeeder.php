<?php

use Illuminate\Database\Seeder;
use App\SellCarAccessory;

class SellCarAccessoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SellCarAccessory::truncate();

        SellCarAccessory::create([
            'sell_car_id' => 1,
            'accessory_id' => 1,
        ]);

        SellCarAccessory::create([
            'sell_car_id' => 1,
            'accessory_id' => 3,
        ]);

        SellCarAccessory::create([
            'sell_car_id' => 1,
            'accessory_id' => 5,
        ]);
    }
}
