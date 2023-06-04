<?php

namespace Database\Seeders;

use App\Models\Item;
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
                'item_id' => Item::factory()->create()->id,
                'color_id' => 1,
            ],
            [
                'item_id' => Item::factory()->create()->id,
                'color_id' => 2,
            ],
            [
                'item_id' => Item::factory()->create()->id,
                'color_id' => 3,
            ],
            [
                'item_id' => Item::factory()->create()->id,
                'color_id' => 2,
            ],
            [
                'item_id' => Item::factory()->create()->id,
                'color_id' => 2,
            ],
            [
                'item_id' => Item::factory()->create()->id,
                'color_id' => 3,
            ],
            [
                'item_id' => Item::factory()->create()->id,
                'color_id' => 2,
            ],
            [
                'item_id' => Item::factory()->create()->id,
                'color_id' => 3,
            ],
            [
                'item_id' => Item::factory()->create()->id,
                'color_id' => 1,
            ],
            [
                'item_id' => Item::factory()->create()->id,
                'color_id' => 3,
            ],
            [
                'item_id' => Item::factory()->create()->id,
                'color_id' => 2,
            ],
            [
                'item_id' => Item::factory()->create()->id,
                'color_id' => 2,
            ],
        ]);
    }
}
