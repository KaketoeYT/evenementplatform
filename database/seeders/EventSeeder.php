<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::create([
            'title' => 'Tech Innovatie Summit',
            'datetime' => Carbon::parse('2026-06-15 10:00:00'),
            'duration' => 180,
            'description' => 'Een dag vol innovatie, AI en softwareontwikkeling trends.',
            'entry_price' => 99.99,
            'category_id' => 1,
            'venue_id' => 1,
        ]);

        Event::create([
            'title' => 'Summer Music Festival',
            'datetime' => Carbon::parse('2026-07-20 14:00:00'),
            'duration' => 360,
            'description' => 'Groot muziekfestival met internationale artiesten en DJ’s.',
            'entry_price' => 59.50,
            'category_id' => 2,
            'venue_id' => 2,
        ]);

        Event::create([
            'title' => 'Startup Networking Night',
            'datetime' => Carbon::parse('2026-05-10 18:30:00'),
            'duration' => 120,
            'description' => 'Netwerkavond voor startups, investeerders en ondernemers.',
            'entry_price' => 25.00,
            'category_id' => 3,
            'venue_id' => 3,
        ]);

        Event::create([
            'title' => 'Food Truck Festival',
            'datetime' => Carbon::parse('2026-08-05 12:00:00'),
            'duration' => 300,
            'description' => 'Geniet van streetfood van top food trucks uit Europa.',
            'entry_price' => 15.00,
            'category_id' => 4,
            'venue_id' => 4,
        ]);

        Event::create([
            'title' => 'Esports Championship 2026',
            'datetime' => Carbon::parse('2026-09-12 09:00:00'),
            'duration' => 480,
            'description' => 'Internationaal gaming toernooi met professionele teams.',
            'entry_price' => 120.00,
            'category_id' => 5,
            'venue_id' => 5,
        ]);
    }
}