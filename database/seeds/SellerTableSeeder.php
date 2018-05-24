<?php

use Illuminate\Database\Seeder;
use App\Seller;
use App\Wallet;

class SellerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Seller::truncate();

        Seller::create([
            'user_id' => 1,
            'wallet_amount' => 100
        ]);

        Wallet::truncate();

        Wallet::create([
            'seller_id' => 1,
            'title' => '新手就給你錢',
            'amount' => 100,
            'remain' => 100
        ]);
    }
}
