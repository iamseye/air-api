<?php

use Illuminate\Database\Seeder;
use App\Equipment;

class EquipmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Equipment::truncate();

        Equipment::create([
            'name' => '電動摺疊後視鏡',
            'category' => 'outside',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => '免鑰匙車門啟閉系統',
            'category' => 'outside',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => 'HID頭燈',
            'category' => 'outside',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => 'LED頭燈',
            'category' => 'outside',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => '電動側滑門',
            'category' => 'outside',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => '鋁圈',
            'category' => 'outside',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => '電動天窗',
            'category' => 'outside',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => '全景式天窗',
            'category' => 'outside',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => '霧燈',
            'category' => 'outside',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => '日行燈',
            'category' => 'outside',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => '恆溫空調',
            'category' => 'inside',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => '衛星導航',
            'category' => 'inside',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => 'DVD影音系統',
            'category' => 'inside',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => '數位電視',
            'category' => 'inside',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => '定速',
            'category' => 'inside',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => '免鑰匙引擎啟閉系統',
            'category' => 'inside',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => '電動座椅',
            'category' => 'inside',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => '第三排座椅',
            'category' => 'inside',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => '皮椅',
            'category' => 'inside',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => '方向盤控制鈕',
            'category' => 'inside',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => '安全氣囊',
            'category' => 'safety',
            'has_value' => true
        ]);

        Equipment::create([
            'name' => '動態巡跡防滑系統',
            'category' => 'safety',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => '倒車影像',
            'category' => 'safety',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => '倒車雷達',
            'category' => 'safety',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => 'ACC主動式定速系統',
            'category' => 'safety',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => '車側盲點偵測系統',
            'category' => 'safety',
            'has_value' => false
        ]);

        Equipment::create([
            'name' => '車道偏移系統',
            'category' => 'safety',
            'has_value' => false
        ]);
    }
}
