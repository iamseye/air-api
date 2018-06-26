<?php

use Illuminate\Database\Seeder;
use App\Area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::truncate();

        Area::create([
            'name' => '台北',
        ]);

        Area::create([
            'name' => '新北',
        ]);

        Area::create([
            'name' => '台中',
        ]);

        Area::create([
            'name' => '台南',
        ]);

        Area::create([
            'name' => '高雄',
        ]);

        Area::create([
            'name' => '宜蘭',
        ]);
    }
}
