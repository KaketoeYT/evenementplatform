<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use App\Models\Queues;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class WachtlijstTest extends TestCase
{
    use RefreshDatabase;

    private function makeUser(): User
    {
        return User::factory()->create(['role' => 'user']);
    }

    private function createVolEvent(): Event
    {
        $venue = Venue::factory()->create(['capacity' => '1']);
        $category = Category::factory()->create();
        $event = Event::factory()->create([
            'category_id' => $category->id,
            'venue_id' => $venue->id,
            'datetime' => now()->addDays(7),
        ]);

        Ticket::create([
            'ticket_number' => 'TKT-FULL0001',
            'rank' => 'Standaard',
            'price' => 10,
            'event_id' => $event->id,
            'user_id' => User::factory()->create()->id,
        ]);

        return $event;
    }

    #[Test]
    public function deelnemer_kan_zich_aanmelden_voor_wachtlijst(): void
    {
        $user = $this->makeUser();
        $event = $this->createVolEvent();

        $response = $this->actingAs($user)->post(route('event.queue', $event), [
            'event_id' => $event->id,
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('queues', [
            'event_id' => $event->id,
            'user_id' => $user->id,
        ]);
    }

    #[Test]
    public function deelnemer_kan_niet_tweemaal_op_wachtlijst(): void
    {
        $user = $this->makeUser();
        $event = $this->createVolEvent();

        Queues::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->post(route('event.queue', $event), [
            'event_id' => $event->id,
        ]);

        $response->assertSessionHas('info');
        $this->assertDatabaseCount('queues', 1);
    }

    #[Test]
    public function wachtlijst_geblokkeerd_na_start_van_evenement(): void
    {
        $user = $this->makeUser();
        $venue = Venue::factory()->create(['capacity' => '100']);
        $category = Category::factory()->create();
        $event = Event::factory()->create([
            'category_id' => $category->id,
            'venue_id' => $venue->id,
            'datetime' => now()->subHour(),
        ]);

        $response = $this->actingAs($user)->post(route('event.queue', $event), [
            'event_id' => $event->id,
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseCount('queues', 0);
    }

    #[Test]
    public function gast_kan_niet_op_wachtlijst(): void
    {
        $venue = Venue::factory()->create(['capacity' => '100']);
        $category = Category::factory()->create();
        $event = Event::factory()->create([
            'category_id' => $category->id,
            'venue_id' => $venue->id,
            'datetime' => now()->addDays(7),
        ]);

        $response = $this->post(route('event.queue', $event), [
            'event_id' => $event->id,
        ]);

        $response->assertRedirect(route('login'));
    }
}
