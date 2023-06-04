<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            [
                'name' => 'Tシャツ1',
                'information' => '情報情報情報情報情報情報情報1',
                'price' => 1000,
                'size_id' => 1,
                'is_selling' => true,
                'sort_order' => 1,
                'secondary_category_id' => 1,
                'image1' => 1,
                'image2' => 2,
                'image3' => 3,
                'image4' => 1,
            ],
            [
                'name' => 'Tシャツ1',
                'information' => '情報情報情報情報情報情報情報1',
                'price' => 1100,
                'size_id' => 1,
                'is_selling' => true,
                'sort_order' => 1,
                'secondary_category_id' => 1,
                'image1' => 1,
                'image2' => 2,
                'image3' => 3,
                'image4' => 1,
            ],
            [
                'name' => 'Tシャツ1',
                'information' => '情報情報情報情報情報情報情報1',
                'price' => 1200,
                'size_id' => 1,
                'is_selling' => true,
                'sort_order' => 1,
                'secondary_category_id' => 1,
                'image1' => 1,
                'image2' => 2,
                'image3' => 3,
                'image4' => 1,
            ],
            [
                'name' => 'Tシャツ2',
                'information' => '情報情報情報情報情報情報情報2',
                'price' => 1500,
                'size_id' => 1,
                'is_selling' => false,
                'sort_order' => 1,
                'secondary_category_id' => 1,
                'image1' => 2,
                'image2' => 2,
                'image3' => 3,
                'image4' => 1,
            ],
            [
                'name' => 'Tシャツ3',
                'information' => '情報情報情報情報情報情報情報3',
                'price' => 2000,
                'size_id' => 2,
                'is_selling' => true,
                'sort_order' => 1,
                'secondary_category_id' => 2,
                'image1' => 3,
                'image2' => 2,
                'image3' => 3,
                'image4' => 1,

            ],
            [
                'name' => 'Tシャツ4',
                'information' => '情報情報情報情報情報情報情報3',
                'price' => 2000,
                'size_id' => 1,
                'is_selling' => true,
                'sort_order' => 1,
                'secondary_category_id' => 2,
                'image1' => 4,
                'image2' => 2,
                'image3' => 3,
                'image4' => 1,

            ],
            [
                'name' => 'Tシャツ5',
                'information' => '情報情報情報情報情報情報情報3',
                'price' => 2000,
                'size_id' => 1,
                'is_selling' => true,
                'sort_order' => 1,
                'secondary_category_id' => 3,
                'image1' => 5,
                'image2' => 2,
                'image3' => 3,
                'image4' => 1,

            ],
            [
                'name' => 'Tシャツ6',
                'information' => '情報情報情報情報情報情報情報3',
                'price' => 2000,
                'size_id' => 2,
                'is_selling' => true,
                'sort_order' => 1,
                'secondary_category_id' => 3,
                'image1' => 6,
                'image2' => 2,
                'image3' => 3,
                'image4' => 1,

            ],
        ]);
    }
}
