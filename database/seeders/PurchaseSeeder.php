<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('purchases')->insert([
        //     [
        //         'user_id' => '',
        //         'name' => '名前　太郎1',
        //         'email' => 'test1@test.com',
        //         'pay' => 'cash',
        //         'postal_code' => '111-1111',
        //         'prefecture' => '大阪府',
        //         'city' => '大阪市',
        //         'address1' => '城東区蒲生',
        //         'address2' => '1-1-1',
        //         'tel' => '000-000-0000',
        //     ],
        // ])
    }
}
