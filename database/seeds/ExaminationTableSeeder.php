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
            'category' => 'accident',
        ]);

        Examination::create([
            'name' => '排除泡水車',
            'category' => 'accident',
        ]);

        Examination::create([
            'name' => '被動安全系統',
            'category' => 'system',
        ]);

        Examination::create([
            'name' => '指示燈檢測',
            'category' => 'system',
        ]);

        Examination::create([
            'name' => '車體外觀',
            'category' => 'looking',
        ]);

        Examination::create([
            'name' => '內裝',
            'category' => 'looking',
        ]);

        Examination::create([
            'name' => '儀表版',
            'category' => 'all',
        ]);

        Examination::create([
            'name' => '中控台',
            'category' => 'all',
        ]);

        Examination::create([
            'name' => '排桿座',
            'category' => 'all',
        ]);

        Examination::create([
            'name' => '電子配備',
            'category' => 'all',
        ]);

        Examination::create([
            'name' => '車門',
            'category' => 'all',
        ]);

        Examination::create([
            'name' => '安全帶',
            'category' => 'all',
        ]);

        Examination::create([
            'name' => '密封條',
            'category' => 'all',
        ]);

        Examination::create([
            'name' => '後車廂',
            'category' => 'all',
        ]);

        Examination::create([
            'name' => '引擎室',
            'category' => 'all',
        ]);
    }
}
