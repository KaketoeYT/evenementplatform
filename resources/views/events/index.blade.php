<x-base-layout>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events | Ticketmaster Style</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">




</head>

<body>
    <div class="container py-5">

        Hello, {{ auth()->user()?->name ?? 'Guest' }}

        <header class="mb-5">
            <h1 class="fw-bold mb-1">My Events</h1>
            <p class="text-muted">Events you're signed up for</p>
        </header>

        @foreach ($myTickets as $ticket)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $ticket->event->title }}</h5>
                    <p class="card-text">{{ \Carbon\Carbon::parse($ticket->event->datetime)->format('F j, Y, g:i a') }}
                    </p>
                    <p class="card-text">{{ $ticket->event->venue->name ?? 'TBA' }} -
                        {{ $ticket->event->venue->city ?? 'Location TBA' }}</p>
                    <a href="#" class="btn btn-primary">View Details</a>
                </div>
            </div>
        @endforeach

        <header class="mb-5">
            <h1 class="fw-bold mb-1">Upcoming Events</h1>
            <p class="text-muted">Discover the best live experience near you.</p>
        </header>

        @foreach ($eventsByCategory as $category => $events)
            <section class="mb-5">
                <div class="category-header d-flex justify-content-between align-items-end mb-4">
                    <h2 class="h3 fw-bold mb-0">{{ $category }}</h2>
                    <a href="#" class="text-decoration-none fw-semibold" style="color: #026cdf;">View All</a>
                </div>

                <div class="row g-4">
                    @foreach ($events as $event)
                        <div class="col-12 col-md-6 col-lg-4">
                            <article class="card h-100 event-card bg-white">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="date-container">
                                            <div class="date-month">
                                                {{ \Carbon\Carbon::parse($event->datetime)->format('M') }}</div>
                                            <div class="date-day">
                                                {{ \Carbon\Carbon::parse($event->datetime)->format('d') }}</div>
                                        </div>
                                        <span class="badge category-pill px-2 py-1">
                                            {{ $event->category->name ?? 'Event' }}
                                        </span>
                                    </div>

                                    <h3 class="event-title mb-1">{{ $event->title }}</h3>
                                    <p class="venue-info mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            fill="currentColor" class="bi bi-geo-alt-fill me-1" viewBox="0 0 16 16">
                                            <path
                                                d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                                        </svg>
                                        {{ $event->venue->name ?? 'TBA' }} —
                                        {{ $event->venue->city ?? 'Location TBA' }}
                                    </p>

                                    <p class="small text-muted mb-4">
                                        {{ \Carbon\Carbon::parse($event->datetime)->format('D • H:i') }} •
                                        {{ $event->duration }} min
                                    </p>

                                    <div class="mt-auto d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="text-muted small">From</div>
                                            <div class="price-text">€{{ number_format($event->entry_price, 2) }}</div>
                                        </div>
                                        
                                    </form>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('events.show', $event->id) }}"
                                                class="btn btn-outline-secondary">Bekijk details</a>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>
</body>
</html>
</x-base-layout>

