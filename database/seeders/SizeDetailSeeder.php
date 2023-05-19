<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('size_details')->insert([
            [
                'size_id' => '1', 
                'name' => '110'
            ],
            [
                'size_id' => '1', 
                'name' => '120'
            ],
            [
                'size_id' => '1', 
                'name' => '130'
            ],
            [
                'size_id' => '2', 
                'name' => 'S'
            ],
            [
                'size_id' => '2', 
                'name' => 'M'
            ],
            [
                'size_id' => '2', 
                'name' => 'L'
            ],
            
            ]);
    }
}
