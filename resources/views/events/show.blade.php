<x-base-layout>

    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f5f5f7;
            }

            .event-detail-card {
                border: none;
                border-radius: 12px;
                overflow: hidden;
            }

            /* Verhoog de 'top' waarde zodat hij onder je header blijft plakken */
            .ticket-sidebar {
                background: #fff;
                border-radius: 12px;
                border: 1px solid #ddd;
                position: sticky;
                top: 100px;
                /* Was 20px, zet deze hoger (bijv. 80px of 100px) afhankelijk van je header hoogte */
                z-index: 10;
                /* Zorg dat hij niet over dropdowns heen valt */
            }

            .price-large {
                font-size: 2rem;
                font-weight: 700;
                color: #2d2d2d;
            }

            .btn-ticketmaster {
                background-color: #026cdf;
                color: white;
                font-weight: 600;
                padding: 12px;
                border-radius: 6px;
                border: none;
                transition: 0.2s;
                width: 100%;
            }

            .btn-ticketmaster:hover {
                background-color: #0151a8;
                color: white;
            }

            .info-label {
                color: #6f7287;
                font-size: 0.85rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                font-weight: 600;
            }

            .info-value {
                color: #2d2d2d;
                font-size: 1.1rem;
                font-weight: 500;
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
            <div class="alert alert-success border-0 shadow-sm mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="row g-4">
            {{-- Linker Kant: Event Details --}}
            <div class="col-lg-8">
                <div class=" event-detail-card shadow-sm p-4 p-md-5 bg-white">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <a href="{{ route('events.index') }}" class="text-decoration-none small fw-bold"
                            style="color: #026cdf;">
                            ← BACK TO EVENTS
                        </a>
                    </nav>

                    <h1 class="display-5 fw-bold mb-4">{{ $event->title }}</h1>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="info-label">DATE & TIME</div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($event->datetime)->format('D, M j, Y • H:i') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-label">LOCATION</div>
                            <div class="info-value">{{ $event->venue->name ?? 'TBA' }}</div>
                            <div class="text-muted small">{{ $event->venue->city ?? 'Location TBA' }}</div>
                        </div>
                    </div>

                    <hr class="my-4" style="opacity: 0.1;">

                    <h4 class="fw-bold mb-3">About This Event</h4>
                    <p class="text-muted" style="line-height: 1.8;">
                        {{ $event->description ?? 'No description available for this event.' }}
                    </p>

                    <div class="mt-4">
                        <span class="badge bg-light text-dark border p-2 px-3">
                            <i class="bi bi-clock me-1"></i> Duration: {{ $event->duration }} min
                        </span>
                    </div>

                    @auth
                        @if (auth()->user()->role == 'organizer')
                            <div class="mt-5 pt-4 border-top d-flex gap-3">
                                <a href="{{ route('events.edit', $event->id) }}"
                                    class="btn btn-sm btn-outline-dark px-4">Edit Event</a>
                                <form method="POST" action="{{ route('events.destroy', $event->id) }}"
                                    onsubmit="return confirm('Zeker weten?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger px-4">Delete</button>
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

                    @if ($event->tickets_count >= $event->venue->capacity)
                        <div class="alert alert-warning text-center fw-bold small">SOLD OUT</div>
                        <form action="{{ route('event.queue', $event->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                            <button type="submit" class="btn btn-warning w-100 fw-bold py-3">
                                JOIN WAITING LIST
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
                        <div class="price-large">€{{ number_format($event->entry_price *2, 2, ',', '.') }}</div>
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
                        <div class="price-large">€{{ number_format($event->entry_price *.75, 2, ',', '.') }}</div>
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
                            <button class="btn btn-secondary w-100 py-3 mb-3" disabled>
                                REGISTRATION CLOSED
                            </button>
                        @endif
                    @endif

                    @auth
                        @if (auth()->user()->role == 'organizer')
                            <a href="{{ route('attendee.index') }}"
                                class="btn btn-link w-100 text-decoration-none text-muted small mt-2">
                                View Attendees
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-base-layout>

