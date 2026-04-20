<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Venue>
 */
class VenueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' Venue',
            'city' => fake()->city(),
            'country' => fake()->country(),
            'street' => fake()->streetAddress(),
            'zipcode' => fake()->postcode(),
            'capacity' => (string) fake()->numberBetween(100, 5000),
        ];
    }
}
