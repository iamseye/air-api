<?php

use Illuminate\Database\Seeder;
use App\SellCar;

class SellCarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SellCar::truncate();

        SellCar::create([
            'seller_id' => 1,
            'car_id' => 1,
            'car_center_id' => 1,
            'description' => 'BENZ賓士C250 W204配置了最新高科技開發出來1.8公升(1796cc)四汽缸渦輪增壓缸內直噴引擎如右圖,這顆BENZ賓士C250車上配置的引擎有204匹馬力(5500rpm),扭力229lb-ft(2,000-4,300rpm),0到100公里加速約7.2秒,因為採用渦輪增壓及缸內直噴等新科技,有更精準快速的點火時間可以達到一毫秒點火四次的精準度,而缸內直噴的新科技更可控制噴油時間精準度到0.1毫秒,精準的點火及噴油產生了更大扭力、更省油、更符合最新環保法規，同時也更安靜。',
            'buy_price' => 1250000,
            'rent_price' => 4000,
            'available_from' => '2018-05-01 00:00:00',
            'available_to' => '2018-09-01 23:59:59',
            'active' => true
        ]);

        SellCar::create([
            'seller_id' => 1,
            'car_id' => 2,
            'car_center_id' => 2,
            'description' => 'BENZ賓士C250 W204配置了最新高科技開發出來1.8公升(1796cc)四汽缸渦輪增壓缸內直噴引擎如右圖,這顆BENZ賓士C250車上配置的引擎有204匹馬力(5500rpm),扭力229lb-ft(2,000-4,300rpm),0到100公里加速約7.2秒,因為採用渦輪增壓及缸內直噴等新科技,有更精準快速的點火時間可以達到一毫秒點火四次的精準度,而缸內直噴的新科技更可控制噴油時間精準度到0.1毫秒,精準的點火及噴油產生了更大扭力、更省油、更符合最新環保法規，同時也更安靜。',
            'buy_price' => 3000000,
            'rent_price' => 8000,
            'available_from' => '2018-05-01 00:00:00',
            'available_to' => '2018-09-01 23:59:59',
            'active' => true
        ]);
    }
}
