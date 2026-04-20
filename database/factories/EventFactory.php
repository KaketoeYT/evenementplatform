<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Event;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'datetime' => fake()->dateTimeBetween('now', '+3 months'),
            'duration' => fake()->numberBetween(60, 360),
            'description' => fake()->paragraph(),
            'entry_price' => fake()->randomFloat(2, 10, 120),
            'category_id' => fake()->numberBetween(1, 3),
            'venue_id' => fake()->numberBetween(1, 3),
        ];
    }
}
