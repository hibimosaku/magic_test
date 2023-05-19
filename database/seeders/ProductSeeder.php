<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'item_id' => 1,
                'color_id' => 1,
            ],
            [
                'item_id' => 2,
                'color_id' => 2,
            ],
            [
                'item_id' => 3,
                'color_id' => 3,
            ],
            [
                'item_id' => 4,
                'color_id' => 2,
            ],
            [
                'item_id' => 5,
                'color_id' => 2,
            ],
            [
                'item_id' => 6,
                'color_id' => 3,
            ],
            [
                'item_id' => 1,
                'color_id' => 2,
            ],
            [
                'item_id' => 1,
                'color_id' => 3,
            ],
            [
                'item_id' => 3,
                'color_id' => 1,
            ],
            [
                'item_id' => 4,
                'color_id' => 3,
            ],
            [
                'item_id' => 5,
                'color_id' => 2,
            ],
            [
                'item_id' => 6,
                'color_id' => 2,
            ],
        ]);
    }
}
