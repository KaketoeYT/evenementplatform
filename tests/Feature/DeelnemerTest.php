<?php

namespace Tests\Feature;

use App\Mail\NewTicketMail;
use App\Models\Category;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DeelnemerTest extends TestCase
{
    use RefreshDatabase;

    private function makeUser(): User
    {
        return User::factory()->create(['role' => 'user']);
    }

    private function createEvent(array $attributes = []): Event
    {
        $category = Category::factory()->create();
        $venue = Venue::factory()->create(['capacity' => '100']);

        return Event::factory()->create(array_merge([
            'category_id' => $category->id,
            'venue_id' => $venue->id,
            'datetime' => now()->addDays(7),
        ], $attributes));
    }

    #[Test]
    public function bezoeker_kan_lijst_van_aankomende_evenementen_zien(): void
    {
        $this->createEvent(['title' => 'Openbaar Festival']);

        $response = $this->get(route('events.index'));

        $response->assertStatus(200);
        $response->assertSee('Openbaar Festival');
    }

    #[Test]
    public function bezoeker_kan_detailpagina_van_evenement_bekijken(): void
    {
        $event = $this->createEvent(['title' => 'Detail Evenement']);

        $response = $this->get(route('events.show', $event));

        $response->assertStatus(200);
        $response->assertSee('Detail Evenement');
    }

    #[Test]
    public function deelnemer_kan_zich_aanmelden_voor_evenement(): void
    {
        Mail::fake();
        $user = $this->makeUser();
        $event = $this->createEvent();

        $response = $this->actingAs($user)->post(route('tickets.ticketstore'), [
            'event_id' => $event->id,
            'rank' => 'Standaard',
            'entry_price' => $event->entry_price,
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('tickets', [
            'event_id' => $event->id,
            'user_id' => $user->id,
        ]);
    }

    #[Test]
    public function vip_ticket_heeft_dubbele_prijs(): void
    {
        Mail::fake();
        $user = $this->makeUser();
        $event = $this->createEvent();

        $this->actingAs($user)->post(route('tickets.ticketstore'), [
            'event_id' => $event->id,
            'rank' => 'VIP',
            'entry_price' => $event->entry_price,
        ]);

        $this->assertDatabaseHas('tickets', [
            'event_id' => $event->id,
            'user_id' => $user->id,
            'rank' => 'VIP',
            'price' => $event->entry_price * 2,
        ]);
    }

    #[Test]
    public function bevestigingsmail_wordt_verstuurd_na_aanmelding(): void
    {
        Mail::fake();
        $user = $this->makeUser();
        $event = $this->createEvent();

        $this->actingAs($user)->post(route('tickets.ticketstore'), [
            'event_id' => $event->id,
            'rank' => 'Standaard',
            'entry_price' => $event->entry_price,
        ]);

        Mail::assertSent(NewTicketMail::class, fn($mail) => $mail->hasTo($user->email));
    }

    #[Test]
    public function aanmelding_geblokkeerd_als_evenement_vol_is(): void
    {
        Mail::fake();
        $user = $this->makeUser();
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

        $response = $this->actingAs($user)->post(route('tickets.ticketstore'), [
            'event_id' => $event->id,
            'rank' => 'Standaard',
            'entry_price' => $event->entry_price,
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('tickets', ['event_id' => $event->id, 'user_id' => $user->id]);
    }

    #[Test]
    public function deelnemer_kan_eigen_aanmeldingen_zien(): void
    {
        $user = $this->makeUser();
        $event = $this->createEvent(['title' => 'Mijn Evenement']);

        Ticket::create([
            'ticket_number' => 'TKT-MYTICKT',
            'rank' => 'Standaard',
            'price' => 20,
            'event_id' => $event->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get(route('events.index'));

        $response->assertStatus(200);
        $response->assertSee('Mijn Evenement');
    }

    #[Test]
    public function deelnemer_kan_zich_afmelden_voor_aankomend_evenement(): void
    {
        $user = $this->makeUser();
        $event = $this->createEvent(['datetime' => now()->addDays(7)]);

        $ticket = Ticket::create([
            'ticket_number' => 'TKT-AFMELD1',
            'rank' => 'Standaard',
            'price' => 15,
            'event_id' => $event->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->post(route('event.afmelden'), [
            'event_id' => $event->id,
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('tickets', ['id' => $ticket->id]);
    }

    #[Test]
    public function afmelden_geblokkeerd_na_start_van_evenement(): void
    {
        $user = $this->makeUser();
        $event = $this->createEvent(['datetime' => now()->subHour()]);

        Ticket::create([
            'ticket_number' => 'TKT-PASTEVT',
            'rank' => 'Standaard',
            'price' => 15,
            'event_id' => $event->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->post(route('event.afmelden'), [
            'event_id' => $event->id,
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('tickets', ['event_id' => $event->id, 'user_id' => $user->id]);
    }

    #[Test]
    public function afmelden_zonder_ticket_geeft_foutmelding(): void
    {
        $user = $this->makeUser();
        $event = $this->createEvent(['datetime' => now()->addDays(7)]);

        $response = $this->actingAs($user)->post(route('event.afmelden'), [
            'event_id' => $event->id,
        ]);

        $response->assertSessionHas('error');
    }

    #[Test]
    public function gast_kan_geen_ticket_reserveren(): void
    {
        $event = $this->createEvent();

        $response = $this->post(route('tickets.ticketstore'), [
            'event_id' => $event->id,
            'rank' => 'Standaard',
            'entry_price' => $event->entry_price,
        ]);

        $response->assertRedirect(route('login'));
    }
}
