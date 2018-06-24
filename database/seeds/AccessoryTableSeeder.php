<?php

use Illuminate\Database\Seeder;
use App\Accessory;

class AccessoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Accessory::truncate();

        Accessory::create([
            'name' => 'GPS'
        ]);

        Accessory::create([
            'name' => '行車記錄器'
        ]);

        Accessory::create([
            'name' => '充電線'
        ]);

        Accessory::create([
            'name' => '音源線'
        ]);

        Accessory::create([
            'name' => '安全帶卡榫夾'
        ]);

        Accessory::create([
            'name' => '空氣濾淨器'
        ]);

        Accessory::create([
            'name' => '手機置放架'
        ]);

        Accessory::create([
            'name' => '其他'
        ]);
    }
}
