<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BeheerderTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdmin(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    private function makeUser(): User
    {
        return User::factory()->create(['role' => 'user']);
    }

    private function makeOrganizer(): User
    {
        return User::factory()->create(['role' => 'organizer']);
    }

    private function createEvent(): Event
    {
        $category = Category::factory()->create();
        $venue = Venue::factory()->create();

        return Event::factory()->create([
            'category_id' => $category->id,
            'venue_id' => $venue->id,
        ]);
    }

    #[Test]
    public function beheerder_kan_alle_evenementen_zien(): void
    {
        $admin = $this->makeAdmin();
        $event = $this->createEvent();

        $response = $this->actingAs($admin)->get(route('admin.events.index'));

        $response->assertStatus(200);
        $response->assertSee($event->title);
    }

    #[Test]
    public function gewone_gebruiker_heeft_geen_toegang_tot_admin_evenementen(): void
    {
        $user = $this->makeUser();

        $response = $this->actingAs($user)->get(route('admin.events.index'));

        $response->assertStatus(403);
    }

    #[Test]
    public function gast_wordt_doorgestuurd_bij_admin_evenementen(): void
    {
        $response = $this->get(route('admin.events.index'));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function beheerder_kan_gebruikersoverzicht_bekijken(): void
    {
        $admin = $this->makeAdmin();
        User::factory()->create(['name' => 'Test Gebruiker']);

        $response = $this->actingAs($admin)->get(route('administrator.user.view'));

        $response->assertStatus(200);
        $response->assertSee('Test Gebruiker');
    }

    #[Test]
    public function niet_beheerder_heeft_geen_toegang_tot_gebruikersbeheer(): void
    {
        $organizer = $this->makeOrganizer();

        $response = $this->actingAs($organizer)->get(route('administrator.user.view'));

        $response->assertStatus(403);
    }

    #[Test]
    public function beheerder_kan_gebruikersrol_bijwerken(): void
    {
        $admin = $this->makeAdmin();
        $user = $this->makeUser();

        $response = $this->actingAs($admin)->post(route('administrator.user.update'), [
            'roles' => [$user->id => 'organizer'],
        ]);

        $response->assertRedirect(route('administrator.user.view'));
        $this->assertDatabaseHas('users', ['id' => $user->id, 'role' => 'organizer']);
    }

    #[Test]
    public function beheerder_kan_rapportages_bekijken(): void
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)->get(route('rapports'));

        $response->assertStatus(200);
    }

    #[Test]
    public function ingelogde_gebruiker_kan_rapportages_bekijken(): void
    {
        $user = $this->makeUser();

        $response = $this->actingAs($user)->get(route('rapports'));

        $response->assertStatus(200);
    }

    #[Test]
    public function gast_heeft_geen_toegang_tot_rapportages(): void
    {
        $response = $this->get(route('rapports'));

        $response->assertRedirect(route('login'));
    }
}
