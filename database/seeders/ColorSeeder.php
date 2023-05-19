<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colors')->insert([
            [
                'name' => '赤'
            ],
            [
                'name' => '青'
            ],
            [
                'name' => '黄'
            ],
            [
                'name' => '白'
            ]
            ]);
    }
}
