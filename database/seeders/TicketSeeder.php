<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Event;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 tickets for random users and events
        $users = User::all();
        $events = Event::all();
        foreach (range(1, 10) as $i) {
            Ticket::create([
                'ticket_number' => 'TICKET-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'rank' => fake()->randomElement(['VIP', 'Standard', 'Economy']),
                'price' => fake()->numberBetween(10, 100),
                'user_id' => $users->random()->id,
                'event_id' => $events->random()->id,
            ]);
        }
    }
}
