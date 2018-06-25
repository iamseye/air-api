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
            'code' => 'OUT_1',
            'category' => 'outside',
        ]);

        Equipment::create([
            'name' => '免鑰匙車門啟閉系統',
            'code' => 'OUT_2',
            'category' => 'outside',
        ]);

        Equipment::create([
            'name' => 'HID頭燈',
            'code' => 'OUT_3',
            'category' => 'outside',
        ]);

        Equipment::create([
            'name' => 'LED頭燈',
            'code' => 'OUT_4',
            'category' => 'outside',
        ]);

        Equipment::create([
            'name' => '電動側滑門',
            'code' => 'OUT_5',
            'category' => 'outside',
        ]);

        Equipment::create([
            'name' => '鋁圈',
            'code' => 'OUT_6',
            'category' => 'outside',
        ]);

        Equipment::create([
            'name' => '電動天窗',
            'code' => 'OUT_7',
            'category' => 'outside',
        ]);

        Equipment::create([
            'name' => '全景式天窗',
            'code' => 'OUT_8',
            'category' => 'outside',
        ]);

        Equipment::create([
            'name' => '霧燈',
            'code' => 'OUT_9',
            'category' => 'outside',
        ]);

        Equipment::create([
            'name' => '日行燈',
            'code' => 'OUT_10',
            'category' => 'outside',
        ]);

        Equipment::create([
            'name' => '恆溫空調',
            'code' => 'IN_1',
            'category' => 'inside',
        ]);

        Equipment::create([
            'name' => '衛星導航',
            'code' => 'IN_2',
            'category' => 'inside',
        ]);

        Equipment::create([
            'name' => 'DVD影音系統',
            'code' => 'IN_3',
            'category' => 'inside',
        ]);

        Equipment::create([
            'name' => '數位電視',
            'code' => 'IN_4',
            'category' => 'inside',
        ]);

        Equipment::create([
            'name' => '定速',
            'code' => 'IN_5',
            'category' => 'inside',
        ]);

        Equipment::create([
            'name' => '免鑰匙引擎啟閉系統',
            'code' => 'IN_6',
            'category' => 'inside',
        ]);

        Equipment::create([
            'name' => '電動座椅',
            'code' => 'IN_7',
            'category' => 'inside',
        ]);

        Equipment::create([
            'name' => '第三排座椅',
            'code' => 'IN_8',
            'category' => 'inside',
        ]);

        Equipment::create([
            'name' => '皮椅',
            'code' => 'IN_9',
            'category' => 'inside',
        ]);

        Equipment::create([
            'name' => '方向盤控制鈕',
            'code' => 'IN_10',
            'category' => 'inside',
        ]);

        Equipment::create([
            'name' => '安全氣囊(2-9顆含以上)',
            'code' => 'S_1',
            'category' => 'safety',
        ]);

        Equipment::create([
            'name' => '動態巡跡防滑系統',
            'code' => 'S_2',
            'category' => 'safety',
        ]);

        Equipment::create([
            'name' => '倒車影像',
            'code' => 'S_3',
            'category' => 'safety',
        ]);

        Equipment::create([
            'name' => '倒車雷達',
            'code' => 'S_4',
            'category' => 'safety',
        ]);

        Equipment::create([
            'name' => 'ACC主動式定速系統',
            'code' => 'S_5',
            'category' => 'safety',
        ]);

        Equipment::create([
            'name' => '車側盲點偵測系統',
            'code' => 'S_6',
            'category' => 'safety',
        ]);

        Equipment::create([
            'name' => '車道偏移系統',
            'code' => 'S_7',
            'category' => 'safety',
        ]);
    }
}
