# Opdrachtgever-review: Ontbrekende functionaliteiten

> **Voor:** ontwikkelteam Evenementenplatform
> **Van:** de opdrachtgever (fictief, t.b.v. de opdracht)
> **Datum:** 3 juni 2026
> **Doel:** Ik heb de huidige versie bekeken. Er staat al een mooie basis: evenementen
> aanmaken, tickets reserveren, een wachtlijst met uitnodigingsmails en rollenbeheer.
> Top. Hieronder beschrijf ik wat ik als klant nog mis voordat ik dit live durf te zetten.
> Per punt staat *wat* ik wil en *waaraan ik het afkeur of goedkeur* (acceptatiecriteria).
> Jullie bepalen zelf *hoe* je het bouwt.

---

## Hoe je dit document gebruikt

1. Lees eerst de **statustabel** — die laat zien welke afgesproken user stories al af zijn en welke niet.
2. Pak daarna de **backlog** erbij. Die is geprioriteerd met **MoSCoW** (Must / Should / Could / Won't).
3. Begin bij de **Must-haves**. Dat zijn dingen die nú stuk zijn of die de afspraak schenden.
4. Schrijf bij elk punt eerst een **test** (Feature test) en bouw daarna de functionaliteit.

---

## Statustabel: afgesproken user stories

| # | User story | Status | Toelichting |
|---|-----------|--------|-------------|
| 1 | Bezoeker ziet lijst aankomende evenementen | ✅ Werkt | Let op: óók afgelopen events worden getoond, zie B-09 |
| 2 | Bezoeker bekijkt detailpagina | ✅ Werkt | Kleine bug in titel, zie B-12 |
| 3 | Deelnemer meldt zich aan | ⚠️ Deels | Geen dubbele-aanmelding-check, zie M-04 |
| 4 | Deelnemer meldt zich af tot de deadline | ⚠️ Deels | Er bestaat géén deadline-veld, zie M-03 |
| 5 | Deelnemer ziet overzicht eigen aanmeldingen | ⚠️ Deels | Status (bevestigd/wachtlijst) ontbreekt, zie S-06 |
| 6 | Organisator maakt evenement aan | ⚠️ Deels | Velden *capaciteit* en *deadline* ontbreken op event, zie M-03 |
| 7 | Organisator bewerkt/verwijdert evenement | ⚠️ Deels | "Alleen eigen evenementen" wordt NIET afgedwongen, zie M-01 |
| 8 | Organisator ziet deelnemerslijst | ⚠️ Deels | Wachtlijst wordt niet apart getoond, zie S-07 |
| 9 | Organisator sluit aanmeldingen | ❌ Mist | Niet gebouwd, zie M-02 |
| 10 | Organisator meldt iemand handmatig af | ❌ Mist | Niet gebouwd, zie S-05 |
| 11 | Beheerder ziet alle evenementen | ✅ Werkt | |
| 12 | Beheerder beheert organisatoraccounts | ⚠️ Deels | Rollen toewijzen werkt; activeren/deactiveren + wachtwoord-reset missen, zie M-05 |
| 13 | Beheerder ziet rapportages | ⚠️ Deels | Alleen "events per maand"; rest ontbreekt, zie M-06 |
| 14 | Bevestigingsmail bij aanmelding | ⚠️ Deels | Mail verstuurt, maar de evenementnaam is leeg (bug), zie M-07 |
| 15 | Authenticatie + rollen + middleware + policies | ⚠️ Deels | Policies ontbreken volledig, zie M-01 |

Legenda: ✅ af · ⚠️ deels af / met gebrek · ❌ ontbreekt

---

## Backlog — Must have (eerst doen)

### M-01 · Een organisator mag alleen zijn eigen evenementen beheren
**Wat ik wil:** Als ik organisator A ben, mag ik niet de evenementen van organisator B
bewerken of verwijderen. Nu kan dat wél: elke organisator kan elk evenement aanpassen.

**Waarom dit Must is:** dit is een afspraak uit de user stories én een veiligheidsgat.
Eén organisator kan het werk van een ander wissen.

**Acceptatiecriteria:**
- [ ] Een evenement heeft een eigenaar (de organisator die het aanmaakte).
- [ ] Organisator B krijgt een 403 (of nette melding) bij bewerken/verwijderen van het evenement van A.
- [ ] De knoppen "Edit" en "Delete" verschijnen alleen bij je eigen evenementen.
- [ ] Een beheerder mag wél alles beheren.

**Hint voor de student:** denk aan een `organizer_id` op `events` en aan een **Policy**
(`php artisan make:policy EventPolicy --model=Event`). De map `app/Policies/` bestaat nog niet.

---

### M-02 · Aanmeldingen kunnen sluiten
**Wat ik wil:** Als organisator wil ik aanmeldingen handmatig kunnen sluiten, los van de capaciteit.
Soms is een evenement nog niet vol, maar wil ik de inschrijving tóch dichtdraaien.

**Acceptatiecriteria:**
- [ ] Er is een aan/uit-status "aanmelding open / gesloten" per evenement.
- [ ] Staat los van de capaciteit (een evenement dat niet vol is, kan toch gesloten zijn).
- [ ] Bezoeker ziet de melding **"Aanmelding gesloten"** in plaats van de aanmeldknop.
- [ ] De backend weigert een aanmelding op een gesloten evenement (niet alleen de knop verbergen).

---

### M-03 · Echte afmeld-deadline per evenement
**Wat ik wil:** Afmelden (en aanmelden) moet kunnen tot een **deadline** die ík bepaal,
niet pas op het moment dat het evenement begint.

**Wat ik nu zie:** de code kijkt naar de starttijd van het evenement (`datetime`). Een apart
deadline-veld bestaat niet, terwijl het in de afspraak staat. Ook de capaciteit hoort volgens
de afspraak bij het *evenement*, maar staat nu alleen bij de *zaal (venue)*.

**Acceptatiecriteria:**
- [ ] Een evenement heeft een veld `deadline` (datum/tijd).
- [ ] Vóór de deadline: aan- en afmelden mag. Ná de deadline: geblokkeerd met nette melding.
- [ ] Het aanmaakformulier vraagt om de deadline en valideert dat die vóór de startdatum ligt.
- [ ] (Wens) Capaciteit instelbaar per evenement, niet alleen via de zaal.

---

### M-04 · Voorkom dubbele aanmeldingen voor hetzelfde evenement
**Wat ik wil:** Eén deelnemer = één plek. Nu kan dezelfde gebruiker meerdere keren op
"Register Now" klikken en meerdere tickets voor hetzelfde evenement krijgen.

**Acceptatiecriteria:**
- [ ] Een gebruiker die al een ticket heeft, kan geen tweede ticket voor hetzelfde evenement maken.
- [ ] De gebruiker krijgt de melding "Je bent al aangemeld voor dit evenement".
- [ ] (Goed gevonden) Dit hoort op de database afgedwongen te worden (unieke combinatie user + event).

---

### M-05 · Beheer van organisatoraccounts afmaken
**Wat ik wil:** Als beheerder de juiste mensen toegang geven én weghalen.

**Wat werkt al:** rollen toewijzen via het admin-scherm. 👍

**Wat mist nog:**
- [ ] Account **activeren / deactiveren** (een gedeactiveerde gebruiker kan niet inloggen).
- [ ] Beheerder kan een **wachtwoord-reset** in gang zetten voor een gebruiker.

**Acceptatiecriteria:**
- [ ] Gedeactiveerd account → inloggen lukt niet, met duidelijke melding.
- [ ] Reset-link/mail werkt en de gebruiker kan een nieuw wachtwoord kiezen.

---

### M-06 · Rapportage compleet maken
**Wat ik wil:** echt inzicht in het gebruik. Nu zie ik alleen "evenementen per maand".

**Acceptatiecriteria (uit de afspraak):**
- [ ] Totaal aantal evenementen.
- [ ] Totaal aantal aanmeldingen (tickets).
- [ ] Het **populairste evenement** (meeste aanmeldingen).
- [ ] **Filter op periode** (van datum – tot datum).

---

### M-07 · Bug: evenementnaam ontbreekt in de bevestigingsmail
**Wat ik zie:** in de bevestigingsmail staat bij "Event:" niets (of "N/A"). De mail leest
`$ticket->event->name`, maar het veld heet `title`. Daardoor weet de deelnemer niet voor
welk evenement hij een ticket heeft — terwijl de afspraak juist zegt: mail bevat naam, datum en locatie.

**Acceptatiecriteria:**
- [ ] De mail toont de juiste evenementnaam, datum en locatie.
- [ ] Datum staat leesbaar geformatteerd (bv. `3 juni 2026, 20:00`).
- [ ] Er is een test die controleert dat de mail de evenementnaam bevat.

---

## Backlog — Should have (kort daarna)

### S-05 · Organisator kan iemand handmatig afmelden
**Wat ik wil:** fouten kunnen corrigeren door een deelnemer zelf af te melden.

**Acceptatiecriteria:**
- [ ] Organisator kan vanuit de deelnemerslijst iemand verwijderen.
- [ ] Reden invullen is optioneel.
- [ ] De vrijgekomen plek activeert automatisch de wachtlijst (zoals bij zelf-afmelden al gebeurt).

---

### S-06 · Deelnemer ziet de status van zijn aanmeldingen
**Wat ik wil:** in "My Events" wil de deelnemer zien of hij **bevestigd** is of op de
**wachtlijst** staat, met datum en locatie.

**Acceptatiecriteria:**
- [ ] Per aanmelding zichtbaar: status (bevestigd / wachtlijst), datum, locatie.
- [ ] Ook wachtlijst-inschrijvingen verschijnen in het overzicht (nu alleen tickets).

---

### S-07 · Wachtlijst apart tonen in de deelnemerslijst
**Wat ik wil:** als organisator de deelnemerslijst bekijk, wil ik bevestigde deelnemers
en wachtlijst **gescheiden** zien.

**Acceptatiecriteria:**
- [ ] Twee duidelijke secties: "Bevestigd" en "Wachtlijst".
- [ ] Wachtlijst toont de volgorde (wie is als eerste aan de beurt).

---

### S-08 · Deelnemer kan zich uit de wachtlijst halen
**Wat ik wil:** wie op de wachtlijst staat maar geen interesse meer heeft, moet eraf kunnen.
Nu kun je er alleen ín, niet meer úit, en je positie is onzichtbaar.

**Acceptatiecriteria:**
- [ ] Knop "Verlaat wachtlijst".
- [ ] De deelnemer ziet zijn positie in de rij (bv. "plek 3 van 7").

---

## Backlog — Could have (mooi meegenomen)

- **C-09 · Zoeken en filteren** op de evenementenlijst (op categorie, datum, plaats). Handig zodra er veel events zijn.
- **C-10 · Categoriebeheer** voor de beheerder. Het model `Category` bestaat, maar er is geen scherm om categorieën toe te voegen of te wijzigen.
- **C-11 · Betaling / afrekenen.** Tickets hebben een prijs (`entry_price`), maar er wordt niets betaald — alles is feitelijk gratis reserveren. Bepaal samen met mij of betalen nodig is.
- **C-12 · Afbeelding/poster per evenement** voor een aantrekkelijkere lijst- en detailpagina.

---

## Losse aandachtspunten / kleine bugs

| Code | Waar | Wat valt op |
|------|------|-------------|
| B-09 | `EventController@index` | Toont álle evenementen, ook afgelopen. "Aankomende evenementen" zou alleen toekomstige moeten tonen. |
| B-12 | `events/show.blade.php` | De `<h1>` gebruikt `$event->titel` (typefout, bestaat niet) waardoor de titel daar leeg is. Eronder staat wél correct `$event->title`. |
| B-13 | `events/show.blade.php` | De `</form>` en `@if/@else` staan door elkaar; er staat ook een dubbele `>` na het formulier. Controleer of de HTML klopt. |
| B-14 | `events/index.blade.php` | Een losse `</form>` zonder openende tag. Opschonen. |
| B-15 | `venues` migratie | `capacity` is opgeslagen als `string`. Voor capaciteits-berekeningen is een `integer` netter. |
| B-16 | Capaciteits-check | Twee mensen kunnen tegelijk het laatste plekje pakken (race condition). Voor de opdracht prima, maar goed om te weten. |

---

## Voorstel voor de aanpak (sprintindeling)

**Sprint 1 — "Afspraken nakomen & repareren":** M-01, M-02, M-03, M-04, M-07 + bugs B-12/B-13.
Dit zijn de dingen die stuk zijn of de afspraak schenden.

**Sprint 2 — "Beheer & inzicht":** M-05, M-06, S-05, S-06, S-07.

**Sprint 3 — "Afmaken & verfijnen":** S-08, Could-haves naar keuze, bugs B-09/B-14/B-15.

> Per user story geldt: **eerst een test schrijven, dan bouwen, dan `php artisan test` draaien.**
> Een functionaliteit is pas "klaar" als alle acceptatiecriteria zijn afgevinkt én de test groen is.
