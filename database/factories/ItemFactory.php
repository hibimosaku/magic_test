<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = Faker::create('ja_JP');
        return [
            'name' => $this->faker->realText(10),
            'information' => $this->faker->realText(50),
            'price' => $this->faker->numberBetween(1000, 5000),
            'size_id' => $this->faker->numberBetween(1, 2),
            'is_selling' => $this->faker->numberBetween(0, 1),
            'sort_order' => $this->faker->randomNumber,
            'secondary_category_id' => $this->faker->numberBetween(1, 4),
            'image1' => $this->faker->numberBetween(1, 6),
            'image2' => $this->faker->numberBetween(1, 6),
            'image3' => $this->faker->numberBetween(1, 6),
            'image4' => $this->faker->numberBetween(1, 6),
            'created_at' => $this->faker->dateTime
        ];
    }
}
