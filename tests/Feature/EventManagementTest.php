<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EventManagementTest extends TestCase
{
    use RefreshDatabase;

    private function makeOrganizer(): User
    {
        return User::factory()->create(['role' => 'organizer']);
    }

    private function makeUser(): User
    {
        return User::factory()->create(['role' => 'user']);
    }

    private function createEvent(array $attributes = []): Event
    {
        $category = Category::factory()->create();
        $venue = Venue::factory()->create();

        return Event::factory()->create(array_merge([
            'category_id' => $category->id,
            'venue_id' => $venue->id,
        ], $attributes));
    }

    #[Test]
    public function organisator_kan_formulier_voor_nieuw_evenement_zien(): void
    {
        $organizer = $this->makeOrganizer();

        $response = $this->actingAs($organizer)->get(route('events.create'));

        $response->assertStatus(200);
    }

    #[Test]
    public function organisator_kan_nieuw_evenement_aanmaken_met_alle_verplichte_velden(): void
    {
        $organizer = $this->makeOrganizer();
        $category = Category::factory()->create();
        $venue = Venue::factory()->create();

        $response = $this->actingAs($organizer)->post(route('events.store'), [
            'title' => 'Rock Festival 2026',
            'datetime' => '2026-07-15 18:00:00',
            'duration' => 240,
            'description' => 'Een geweldig muziekfestival in de open lucht.',
            'entry_price' => 49.99,
            'category_id' => $category->id,
            'venue_id' => $venue->id,
        ]);

        $response->assertRedirect(route('events.index'));
        $this->assertDatabaseHas('events', ['title' => 'Rock Festival 2026']);
    }

    #[Test]
    public function aanmaken_evenement_mislukt_zonder_verplichte_velden(): void
    {
        $organizer = $this->makeOrganizer();

        $response = $this->actingAs($organizer)->post(route('events.store'), []);

        $response->assertSessionHasErrors([
            'title',
            'datetime',
            'duration',
            'description',
            'entry_price',
            'category_id',
            'venue_id',
        ]);
    }

    #[Test]
    public function aanmaken_evenement_mislukt_met_niet_bestaande_categorie(): void
    {
        $organizer = $this->makeOrganizer();
        $venue = Venue::factory()->create();

        $response = $this->actingAs($organizer)->post(route('events.store'), [
            'title' => 'Test Evenement',
            'datetime' => '2026-07-15 18:00:00',
            'duration' => 120,
            'description' => 'Test beschrijving.',
            'entry_price' => 20.00,
            'category_id' => 9999,
            'venue_id' => $venue->id,
        ]);

        $response->assertSessionHasErrors(['category_id']);
    }

    #[Test]
    public function organisator_kan_bewerkformulier_van_evenement_zien(): void
    {
        $organizer = $this->makeOrganizer();
        $event = $this->createEvent();

        $response = $this->actingAs($organizer)->get(route('events.edit', $event));

        $response->assertStatus(200);
        $response->assertSee($event->title);
    }

    #[Test]
    public function organisator_kan_evenement_bijwerken(): void
    {
        $organizer = $this->makeOrganizer();
        $category = Category::factory()->create();
        $venue = Venue::factory()->create();
        $event = Event::factory()->create([
            'category_id' => $category->id,
            'venue_id' => $venue->id,
        ]);

        $response = $this->actingAs($organizer)->put(route('events.update', $event), [
            'title' => 'Bijgewerkte Festivaltitel',
            'datetime' => '2026-08-01 20:00:00',
            'duration' => 180,
            'description' => 'Bijgewerkte beschrijving.',
            'entry_price' => 35.00,
            'category_id' => $category->id,
            'venue_id' => $venue->id,
        ]);

        $response->assertRedirect(route('events.index'));
        $this->assertDatabaseHas('events', ['title' => 'Bijgewerkte Festivaltitel']);
    }

    #[Test]
    public function organisator_kan_evenement_verwijderen(): void
    {
        $organizer = $this->makeOrganizer();
        $event = $this->createEvent();

        $response = $this->actingAs($organizer)->delete(route('events.destroy', $event));

        $response->assertRedirect(route('events.index'));
        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }

    #[Test]
    public function organisator_kan_aangemelde_bezoekers_van_evenement_zien(): void
    {
        $organizer = $this->makeOrganizer();
        $user = User::factory()->create(['name' => 'Jan Jansen']);
        $event = $this->createEvent();

        Ticket::create([
            'ticket_number' => 'TKT-SHOWUSR1',
            'rank' => 'Standaard',
            'price' => 10,
            'event_id' => $event->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($organizer)->get(route('event.show.user', $event));

        $response->assertStatus(200);
        $response->assertSee('Jan Jansen');
    }

    #[Test]
    public function gewone_gebruiker_heeft_geen_toegang_tot_aanmaken_evenement(): void
    {
        $user = $this->makeUser();

        $response = $this->actingAs($user)->get(route('events.create'));

        $response->assertStatus(403);
    }

    #[Test]
    public function gewone_gebruiker_kan_geen_evenement_opslaan(): void
    {
        $user = $this->makeUser();
        $category = Category::factory()->create();
        $venue = Venue::factory()->create();

        $response = $this->actingAs($user)->post(route('events.store'), [
            'title' => 'Ongeoorloofd Evenement',
            'datetime' => '2026-07-15 18:00:00',
            'duration' => 120,
            'description' => 'Dit mag niet.',
            'entry_price' => 20.00,
            'category_id' => $category->id,
            'venue_id' => $venue->id,
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('events', ['title' => 'Ongeoorloofd Evenement']);
    }

    #[Test]
    public function gewone_gebruiker_kan_geen_evenement_verwijderen(): void
    {
        $user = $this->makeUser();
        $event = $this->createEvent();

        $response = $this->actingAs($user)->delete(route('events.destroy', $event));

        $response->assertStatus(403);
        $this->assertDatabaseHas('events', ['id' => $event->id]);
    }

    #[Test]
    public function gast_wordt_doorgestuurd_naar_login_bij_aanmaken_evenement(): void
    {
        $response = $this->get(route('events.create'));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function gast_kan_geen_evenement_opslaan(): void
    {
        $response = $this->post(route('events.store'), [
            'title' => 'Gast Evenement',
        ]);

        $response->assertRedirect(route('login'));
    }
}
