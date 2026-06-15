<x-base-layout>

    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons voor mooie, strakke icoontjes -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f8f9fa;
            }

            /* Container voor de afbeelding die zorgt dat alles netjes meeschaalt */
            .event-image-wrapper {
                width: 100%;
                background-color: #e9ecef;
                border-radius: 16px;
                overflow: hidden;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .event-image-wrapper img {
                width: 100%;
                height: auto;
                max-height: 500px;
                /* Voorkomt dat verticale foto's het hele scherm overnemen */
                object-fit: contain;
                /* Zorgt dat de afbeelding NOOIT wordt afgesneden */
                display: block;
            }

            /* Content Kaart styling */
            .event-detail-card {
                border: none;
                border-radius: 16px;
            }

            /* Iconen naast de hoofdinfo */
            .info-icon-box {
                width: 48px;
                height: 48px;
                background-color: #f0f7ff;
                color: #026cdf;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.25rem;
            }

            /* Sticky Sidebar voor tickets */
            .ticket-sidebar {
                background: #ffffff;
                border-radius: 16px;
                border: 1px solid #e9ecef;
                position: sticky;
                top: 40px;
                z-index: 10;
            }

            .price-large {
                font-size: 2.25rem;
                font-weight: 700;
                color: #212529;
            }

            .btn-ticketmaster {
                background-color: #026cdf;
                color: white;
                font-weight: 600;
                padding: 14px;
                border-radius: 10px;
                border: none;
                transition: background-color 0.2s ease, transform 0.1s ease;
                width: 100%;
            }

            .btn-ticketmaster:hover {
                background-color: #0151a8;
                color: white;
                transform: translateY(-1px);
            }

            .btn-ticketmaster:active {
                transform: translateY(1px);
            }

            .info-label {
                color: #6c757d;
                font-size: 0.8rem;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                font-weight: 700;
            }

            .info-value {
                color: #212529;
                font-size: 1.1rem;
                font-weight: 600;
            }
        </style>
    </head>

    @if (session('info'))
        <script>
            alert('Je bent al aangemeld voor de wachtrij!');
        </script>
    @endif

    <div class="container py-5">
        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 p-3 rounded-3"
                role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Navigatie bovenin --}}
        <div class="mb-4">
            <a href="{{ route('events.index') }}"
                class="text-decoration-none small fw-bold d-inline-flex align-items-center" style="color: #026cdf;">
                <i class="bi bi-arrow-left me-2"></i> BACK TO EVENTS
            </a>
        </div>

        <div class="row g-4">
            {{-- Linker Kant: Event Details --}}
            <div class="col-lg-8">

                {{-- Prachtige, responsive afbeelding container --}}
                @if ($event->image_url)
                    <div class="event-image-wrapper shadow-sm mb-4">
                        <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}">
                    </div>
                @endif

                <div class="event-detail-card shadow-sm p-4 p-md-5 bg-white">
                    {{-- De Titel staat nu altijd clean en leesbaar op de witte achtergrond --}}
                    <h1 class="display-5 fw-bold mb-4 text-dark">{{ $event->title }}</h1>

                    {{-- Belangrijke data / Locatie Grid --}}
                    <div class="row g-4 mb-4">
                        <div class="col-md-6 d-flex align-items-start gap-3">
                            <div class="info-icon-box">
                                <i class="bi bi-calendar3"></i>
                            </div>
                            <div>
                                <div class="info-label">Date & Time</div>
                                <div class="info-value">
                                    {{ \Carbon\Carbon::parse($event->datetime)->format('D, M j, Y • H:i') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex align-items-start gap-3">
                            <div class="info-icon-box">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div>
                                <div class="info-label">Location</div>
                                <div class="info-value">{{ $event->venue->name ?? 'TBA' }}</div>
                                <div class="text-muted small">{{ $event->venue->city ?? 'Location TBA' }}</div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4" style="opacity: 0.1;">

                    {{-- Beschrijving --}}
                    <h4 class="fw-bold mb-3">About This Event</h4>
                    <p class="text-secondary mb-4" style="line-height: 1.8; font-size: 1.05rem;">
                        {{ $event->description ?? 'No description available for this event.' }}
                    </p>

                    {{-- Extra meta-informatie badges --}}
                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <span
                            class="badge bg-light text-dark border p-2 px-3 rounded-pill d-inline-flex align-items-center">
                            <i class="bi bi-clock me-2 text-primary"></i> Duration: {{ $event->duration }} min
                        </span>
                        @if ($event->category)
                            <span
                                class="badge bg-light text-dark border p-2 px-3 rounded-pill d-inline-flex align-items-center">
                                <i class="bi bi-tags me-2 text-primary"></i> {{ $event->category->name }}
                            </span>
                        @endif
                    </div>

                    <div class="mt-5 pt-4 border-top d-flex gap-3">
                        <form action="{{ route('event.favorite', $event->id) }}" method="POST" class="d-inline">
                            @csrf
                            @if ($isFavorited)
                                <button type="submit" class="btn btn-success px-4 rounded-3 fw-medium">
                                    <i class="bi bi-heart-fill me-2"></i>Favorited
                                </button>
                            @else
                                <button type="submit" class="btn btn-outline-secondary px-4 rounded-3 fw-medium">
                                    <i class="bi bi-heart me-2"></i>Favorite
                                </button>
                            @endif
                        </form>
                    </div>

                    {{-- Beheeropties voor Organizers --}}
                    @auth
                        @if (auth()->user()->role == 'organizer')
                            <div class="mt-5 pt-4 border-top d-flex gap-3">
                                <a href="{{ route('events.edit', $event->id) }}"
                                    class="btn btn-outline-secondary px-4 rounded-3 fw-medium">
                                    <i class="bi bi-pencil me-2"></i>Edit Event
                                </a>
                                <form method="POST" action="{{ route('events.destroy', $event->id) }}"
                                    onsubmit="return confirm('Weet je zeker dat je dit evenement wilt verwijderen?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger px-4 rounded-3 fw-medium">
                                        <i class="bi bi-trash me-2"></i>Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- Rechter Kant: Ticket Box --}}
            <div class="col-lg-4">
                <div class="ticket-sidebar shadow-sm p-4 sticky-top" style="top: 20px;">
                    <div class="mb-4">
                        <div class="info-label mb-1">PRICE FOR STANDING</div>
                        <div class="price-large">€{{ number_format($event->entry_price, 2, ',', '.') }}</div>
                    </div>

                    {{-- Ticket status logica --}}
                    @if ($event->tickets_count >= $event->venue->capacity)
                        <div class="alert alert-danger text-center fw-bold small rounded-3 py-3 mb-3">
                            <i class="bi bi-exclamation-octagon-fill me-2"></i>SOLD OUT
                        </div>
                        <form action="{{ route('event.queue', $event->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                            <button type="submit" class="btn btn-warning w-100 fw-bold py-3 rounded-3 text-dark">
                                <i class="bi bi-hourglass-split me-2"></i>JOIN WAITING LIST
                            </button>
                        </form>
                    @else
                        @if ($event->canRegister())
                            <form action="{{ route('tickets.ticketstore') }}" method="POST">
                                @csrf
                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                                <input type="hidden" name="rank" value="standard">
                                <input type="hidden" name="entry_price" value="{{ $event->entry_price }}">
                                <button type="submit" class="btn btn-ticketmaster shadow-sm mb-3">
                                    GET STANDING TICKETS
                                </button>
                            </form>

                            @if ($event->vip_active)
                                <div class="mb-4">
                                    <div class="info-label mb-1">PRICE FOR VIP</div>
                                    <div class="price-large">€{{ number_format($event->entry_price * 2, 2, ',', '.') }}
                                    </div>
                                </div>

                                <form action="{{ route('tickets.ticketstore') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    <input type="hidden" name="rank" value="VIP">
                                    <input type="hidden" name="entry_price" value="{{ $event->entry_price }}">
                                    <button type="submit" class="btn btn-ticketmaster shadow-sm mb-3">
                                        GET VIP TICKETS
                                    </button>
                                </form>
                            @endif

                            @if ($event->seated_active)
                                <div class="mb-4">
                                    <div class="info-label mb-1">PRICE FOR SEATED</div>
                                    <div class="price-large">
                                        €{{ number_format($event->entry_price * 0.75, 2, ',', '.') }}</div>
                                </div>
                                <form action="{{ route('tickets.ticketstore') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    <input type="hidden" name="rank" value="seated">
                                    <input type="hidden" name="entry_price" value="{{ $event->entry_price }}">
                                    <button type="submit" class="btn btn-ticketmaster shadow-sm mb-3">
                                        GET SEATED TICKETS
                                    </button>
                                </form>
                            @endif
                        @else
                            <button class="btn btn-secondary w-100 py-3 mb-2 rounded-3" disabled>
                                <i class="bi bi-lock-fill me-2"></i>REGISTRATION CLOSED
                            </button>
                        @endif
                    @endif

                    @auth
                        @if (auth()->user()->role == 'organizer')
                            <a href="{{ route('attendee.index') }}"
                                class="btn btn-link w-100 text-decoration-none text-muted small mt-3 fw-medium d-inline-flex align-items-center justify-content-center">
                                <i class="bi bi-people me-2"></i> View Attendees
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-base-layout>

