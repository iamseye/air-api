<?php

use Illuminate\Database\Seeder;
use App\VehicleType;
use App\VehicleBrand;

class VehicleInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VehicleType::truncate();

        VehicleType::create([
            'name' => '四門房車',
        ]);

        VehicleType::create([
            'name' => '休旅車',
        ]);

        VehicleType::create([
            'name' => '敞篷車',
        ]);

        VehicleType::create([
            'name' => '性能跑車',
        ]);

        VehicleBrand::truncate();

        VehicleBrand::create([
            'name' => 'BMW',
            'name_ch' => '逼恩搭不溜',
        ]);

        VehicleBrand::create([
            'name' => 'Audi',
            'name_ch' => '奧迪',
        ]);

        VehicleBrand::create([
            'name' => 'Benz',
            'name_ch' => '賓士',
        ]);

        VehicleBrand::create([
            'name' => 'Ford',
            'name_ch' => '福特'
        ]);
    }
}
