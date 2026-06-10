# TODO — Verbeteringen & Features Evenementplatform

Bevindingen uit de code-review, geprioriteerd. Vink af tijdens het werken.

## 🔴 Belangrijk — beveiliging & autorisatie

- [ ] **`toggleRegistration` staat buiten elke middleware** (`routes/web.php`). Deze regel staat ná de auth-groepen zónder middleware → elke gast kan de aanmeldingsstatus van elk event omzetten. Verplaats naar de organizer-groep.
- [ ] **Geen eigenaarschap op events**. De `events`-tabel heeft geen `organizer_id`/`user_id`. Gevolg: elke organizer kan elk event van een ander bewerken/verwijderen, en "mijn events" is niet mogelijk. Voeg een `organizer_id` foreign key toe.
- [ ] **Alle FormRequests hebben `authorize() { return true; }`**. Geen Policies aanwezig. De rolcheck bepaalt alleen óf je organizer bent, niet óf het jouw event is. Maak een `EventPolicy` gekoppeld aan ownership.
- [ ] **Dubbele routes** in `web.php`: `deactivate_user` en `mails.password_reset` staan twee keer. Opruimen.

## 🔴 Belangrijk — correctheid & data-integriteit

- [ ] **`ticketstore()` opschonen + race condition**. `canRegister()` checkt al alles, maar daarna volgen nog 2× dezelfde capaciteitscheck en wordt `$event` opnieuw opgehaald. Geen transactie/locking → oversell mogelijk bij gelijktijdige aanmeldingen. Wikkel in `DB::transaction` met `lockForUpdate()`.
- [ ] **Voorkom dubbele tickets**: niets verhindert dat dezelfde user meerdere tickets voor hetzelfde event koopt.
- [ ] **`ticket.price` is `integer`** in de migratie, maar de logica doet `* 0.75` en `* 2` → decimalen worden afgekapt. Maak er `decimal(10,2)` van.
- [ ] **`claim()` gebruikt andere prijslogica** dan `ticketstore()` (vaste `entry_price`, rank `'Standard'`). Trek de ticket-aanmaak samen in één service/methode.
- [ ] **`joinQueue($request, $eventId)`** negeert de route-parameter en gebruikt `$request->event_id`. Gebruik de route-binding consequent (`Event $event`).
- [ ] **Unique constraints ontbreken**:
  - `favorites`: geen `unique(['user_id','event_id'])` → dubbele favorieten. Bovendien is de `down()` leeg.
  - `queues`: losse `unsignedBigInteger` zónder foreign keys, geen `unique(['user_id','event_id'])`, `invited_at` zonder cast in het model.
- [ ] **`update()` verwerkt geen image-upload** terwijl `store()` dat wél doet. Bewerken verliest de afbeeldingfunctionaliteit.

## 🟡 Kwaliteit & performance

- [ ] **Mails worden synchroon verstuurd** (`Mail::to()->send()`). Gebruik `ShouldQueue` / `->queue()`.
- [ ] **Geen paginering**: `index()`, `index_admin()`, `RapportController` doen `Event::all()`/`->get()`. Gebruik `paginate()`.
- [ ] **`RapportController`** groepeert per maand in PHP. Doe dit in SQL (`selectRaw` + `groupBy`).
- [ ] **Ontbrekende relaties**: `Favorite` heeft geen `user()`/`event()`, `Event` heeft geen `favorites()`/`queue()`. Verhindert eager loading.
- [ ] **Geen toekomst-validatie op `datetime`**: voeg `after:now` toe in de Event-requests.
- [ ] **Dode code opruimen**: uitgecommentarieerde regels in `mijntickets()` en modellen.
- [ ] **Tests vs. instructies**: `tests/Pest.php` bestaat, maar `CLAUDE.md`/`AGENTS.md` schrijven PHPUnit voor. Kies één lijn.

## 🟢 Feature-ideeën

- [ ] **Zoeken & filteren** op events (datum, categorie, locatie, prijs).
- [ ] **QR-code op tickets** + check-in scan voor organizer.
- [ ] **Betaling** (Mollie/Stripe) i.p.v. gratis reserveren.
- [ ] **Notificaties/herinneringen** (X dagen voor event) via queue.
- [ ] **Favorieten-overzichtspagina** (favorieten worden opgeslagen maar nergens getoond).
- [ ] **Capaciteit per rank** (VIP/seated/standard apart).
- [ ] **Wachtrijpositie tonen** aan de gebruiker.
- [ ] **iCal-export / "Toevoegen aan agenda"**.

## Aanbevolen volgorde

1. `toggleRegistration` achter middleware zetten (kritieke fix).
2. `organizer_id` + `EventPolicy` (eigenaarschap).
3. `ticketstore()` opschonen + transactie/locking + `decimal` prijs.
4. Unique constraints op `favorites`/`queues` + foreign keys.
5. Mails queueën + paginering.
