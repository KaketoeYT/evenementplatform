<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => fake()->company().' '.fake()->word(),
            'datetime' => fake()->dateTimeBetween('now', '+3 months'),
            'duration' => fake()->numberBetween(60, 360),
            'description' => fake()->paragraph(),
            'entry_price' => fake()->randomFloat(2, 10, 120),
            'category_id' => Category::factory(),
            'venue_id' => Venue::factory(),
            'organizer_id' => User::factory()->state(['role' => 'organizer']),
        ];
    }
}
