<?php

use Illuminate\Database\Seeder;
use App\Examination;

class ExaminationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Examination::truncate();

        Examination::create([
            'name' => '排除重大撞擊',
            'code' => 'ACC_1',
            'category' => 'accident',
        ]);

        Examination::create([
            'name' => '排除泡水車',
            'code' => 'ACC_2',
            'category' => 'accident',
        ]);

        Examination::create([
            'name' => '被動安全系統',
            'code' => 'SYS_1',
            'category' => 'system',
        ]);

        Examination::create([
            'name' => '指示燈檢測',
            'code' => 'SYS_2',
            'category' => 'system',
        ]);

        Examination::create([
            'name' => '車體外觀',
            'code' => 'LOOK_1',
            'category' => 'looking',
        ]);

        Examination::create([
            'name' => '內裝',
            'code' => 'LOOK_1',
            'category' => 'looking',
        ]);

        Examination::create([
            'name' => '儀表版',
            'code' => 'ALL_1',
            'category' => 'all',
        ]);

        Examination::create([
            'name' => '中控台',
            'code' => 'ALL_2',
            'category' => 'all',
        ]);

        Examination::create([
            'name' => '排桿座',
            'code' => 'ALL_3',
            'category' => 'all',
        ]);

        Examination::create([
            'name' => '電子配備',
            'code' => 'ALL_4',
            'category' => 'all',
        ]);

        Examination::create([
            'name' => '車門',
            'code' => 'ALL_5',
            'category' => 'all',
        ]);

        Examination::create([
            'name' => '安全帶',
            'code' => 'ALL_6',
            'category' => 'all',
        ]);

        Examination::create([
            'name' => '密封條',
            'code' => 'ALL_7',
            'category' => 'all',
        ]);

        Examination::create([
            'name' => '後車廂',
            'code' => 'ALL_8',
            'category' => 'all',
        ]);

        Examination::create([
            'name' => '引擎室',
            'code' => 'ALL_9',
            'category' => 'all',
        ]);
    }
}
