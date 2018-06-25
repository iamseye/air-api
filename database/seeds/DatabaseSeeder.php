<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CarCenterTableSeeder::class,
            CarTableSeeder::class,
            SellCarTableSeeder::class,
            SellerTableSeeder::class,
            PromoCodesTableSeeder::class,
            EquipmentTableSeeder::class,
            AccessoryTableSeeder::class,
            EquipmentTableSeeder::class,
        ]);
    }
}
