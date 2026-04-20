<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venue;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Venue::create([
            'name' => 'Tech Hub Amsterdam',
            'city' => 'Amsterdam',
            'country' => 'Netherlands',
            'street' => 'Damrak 1',
            'zipcode' => '1012 LG',
            'capacity' => '500',
        ]);

        Venue::create([
            'name' => 'Music Park Rotterdam',
            'city' => 'Rotterdam',
            'country' => 'Netherlands',
            'street' => 'Parklaan 10',
            'zipcode' => '3016 BB',
            'capacity' => '2000',
        ]);

        Venue::create([
            'name' => 'Business Center Utrecht',
            'city' => 'Utrecht',
            'country' => 'Netherlands',
            'street' => 'Stationsplein 5',
            'zipcode' => '3511 ED',
            'capacity' => '300',
        ]);
    }
}