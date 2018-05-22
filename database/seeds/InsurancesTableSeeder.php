<?php

use App\Insurance;
use Illuminate\Database\Seeder;

class InsurancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Insurance::truncate();

        Insurance::create([
            'name' => 1,
            'company' => 'XX銀行',
            'price' => 2500,
            'description' => '保障車輛自體或與其他車輛碰撞之損失&保障火災、閃電、爆炸或墜落物造成之損失&免追償條款&失竊險',
        ]);
    }
}
