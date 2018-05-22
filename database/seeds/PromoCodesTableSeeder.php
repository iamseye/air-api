<?php

use App\PromoCode;
use Illuminate\Database\Seeder;

class PromoCodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PromoCode::truncate();

        PromoCode::create([
            'code' => 'JESSIE_TEST',
            'expired_at' => 20181231,
            'amount' => 1000,
            'percentage' => 0,
        ]);

        PromoCode::create([
            'code' => 'JESSIE_TEST_P',
            'expired_at' => 20181231,
            'amount' => 0,
            'percentage' => 10,
        ]);
    }
}
