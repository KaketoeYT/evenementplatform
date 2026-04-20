<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use App\Models\Venue;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a single test user

        User::factory()->create([
            'name' => 'user',
            'email' => 'user@user.nl',
            'role' => 'user',
        ]);

        User::factory()->create([
            'name' => 'organ',
            'email' => 'organ@organ.nl',
            'role' => 'organizer',
        ]);

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.nl',
            'role' => 'admin',
        ]);

        // Create categories and venues first
        Category::factory()->count(3)->create();
        Venue::factory()->count(3)->create();

        // Create 15 events linked to the seeded categories and venues
        Event::factory()->count(15)->create();
    }
}
