<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('images')->insert([
            [
                'filename' => 'sample1.jpg',
                'title' => 'sample1'
            ],
            [
                'filename' => 'sample2.jpg',
                'title' => 'sample2'
            ],
            [
                'filename' => 'sample3.jpg',
                'title' => 'sample3'
            ],
            [
                'filename' => 'sample4.jpg',
                'title' => 'sample4'
            ],
            [
                'filename' => 'sample5.jpg',
                'title' => 'sample5'
            ],
            [
                'filename' => 'sample6.jpg',
                'title' => 'sample6'
            ],
        ]);
    }
}
