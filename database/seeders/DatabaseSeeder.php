<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Color;
use App\Models\Size;
use App\Models\SizeDetail;
use App\Models\PrimaryCategory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            ColorSeeder::class,
            SizeSeeder::class,
            UserSeeder::class,
            ImageSeeder::class,
            PrimaryCategorySeeder::class,
            SecondaryCategorySeeder::class,
            ItemSeeder::class,
            ProductSeeder::class,
            SizeDetailSeeder::class,
        ]);
    }
}
