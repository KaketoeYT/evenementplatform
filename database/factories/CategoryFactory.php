<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Technology',
                'Music',
                'Business',
                'Sports',
                'Food & Drink',
                'Arts & Culture',
            ]),
        ];
    }
}
