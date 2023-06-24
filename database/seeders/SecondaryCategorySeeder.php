<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecondaryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('secondary_categories')->insert([
            [
                'name' => '幼児男',
                'primary_category_id' => 1,
                'sort_order' => 1
            ],
            [
                'name' => '幼児女',
                'primary_category_id' => 1,
                'sort_order' => 2
            ],
            [
                'name' => 'ゴルフ',
                'primary_category_id' => 2,
                'sort_order' => 1
            ],
            [
                'name' => '卓球',
                'primary_category_id' => 2,
                'sort_order' => 2
            ],
        ]);
    }
}
