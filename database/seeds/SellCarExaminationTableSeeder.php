<?php

use Illuminate\Database\Seeder;
use App\SellCarExamination;

class SellCarExaminationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SellCarExamination::truncate();

        SellCarExamination::create([
            'sell_car_id' => 1,
            'examination_id' => 1,
            'pic_url' => 'https://aircnc.com.tw/upload/users/album/source_img/2018-05-22-791-15449.jpg',
            'passed' => true,
        ]);

        SellCarExamination::create([
            'sell_car_id' => 1,
            'examination_id' => 2,
            'pic_url' => 'https://aircnc.com.tw/upload/users/album/source_img/2018-05-22-791-15449.jpg',
            'passed' => true,
        ]);

        SellCarExamination::create([
            'sell_car_id' => 1,
            'examination_id' => 3,
            'pic_url' => 'https://aircnc.com.tw/upload/users/album/source_img/2018-05-22-791-15449.jpg',
            'passed' => true,
        ]);

        SellCarExamination::create([
            'sell_car_id' => 1,
            'examination_id' => 4,
            'pic_url' => 'https://aircnc.com.tw/upload/users/album/source_img/2018-05-22-791-15449.jpg',
            'passed' => true,
        ]);

        SellCarExamination::create([
            'sell_car_id' => 1,
            'examination_id' => 5,
            'passed' => true,
        ]);

        SellCarExamination::create([
            'sell_car_id' => 1,
            'examination_id' => 6,
            'passed' => true,
        ]);

        SellCarExamination::create([
            'sell_car_id' => 1,
            'examination_id' => 7,
            'pic_url' => 'https://aircnc.com.tw/upload/users/album/source_img/2018-05-22-791-15449.jpg',
            'passed' => true,
        ]);

        SellCarExamination::create([
            'sell_car_id' => 1,
            'examination_id' => 8,
            'passed' => true,
        ]);

        SellCarExamination::create([
            'sell_car_id' => 1,
            'examination_id' => 9,
            'passed' => true,
        ]);

        SellCarExamination::create([
            'sell_car_id' => 1,
            'examination_id' => 10,
            'pic_url' => 'https://aircnc.com.tw/upload/users/album/source_img/2018-05-22-791-15449.jpg',
            'passed' => true,
        ]);

        SellCarExamination::create([
            'sell_car_id' => 1,
            'examination_id' => 11,
            'passed' => true,
        ]);

        SellCarExamination::create([
            'sell_car_id' => 1,
            'examination_id' => 12,
            'pic_url' => 'https://aircnc.com.tw/upload/users/album/source_img/2018-05-22-791-15449.jpg',
            'passed' => false,
            'remarks' => '有泡水痕跡'
        ]);

        SellCarExamination::create([
            'sell_car_id' => 1,
            'examination_id' => 13,
            'passed' => true,
        ]);

        SellCarExamination::create([
            'sell_car_id' => 1,
            'examination_id' => 14,
            'passed' => true,
        ]);

        SellCarExamination::create([
            'sell_car_id' => 1,
            'examination_id' => 15,
            'passed' => true,
        ]);

    }
}
