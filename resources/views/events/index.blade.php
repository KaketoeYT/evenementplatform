<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events | Ticketmaster Style</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

    <style>
        body {
            background-color: #f5f5f7;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #262626;
        }

        /* Category Headers */
        .category-header {
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 1rem;
        }

        /* Card Styling */
        .event-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            border: 1px solid #e0e0e0 !important;
            border-radius: 8px;
        }

        .event-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
        }

        /* Date Badge (Ticketmaster Signature style) */
        .date-container {
            text-transform: uppercase;
            font-weight: 700;
            line-height: 1;
            color: #026cdf;
        }

        .date-day { font-size: 1.25rem; }
        .date-month { font-size: 0.85rem; }

        /* Typography */
        .event-title {
            font-weight: 700;
            color: #262626;
            font-size: 1.1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 2.6rem;
        }

        .venue-info {
            font-size: 0.9rem;
            color: #6f6f6f;
            font-weight: 400;
        }

        /* Primary Button */
        .btn-ticketmaster {
            background-color: #026cdf;
            border-color: #026cdf;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            transition: background-color 0.2s;
        }

        .btn-ticketmaster:hover {
            background-color: #014ea3;
            border-color: #014ea3;
        }

        .price-text {
            font-size: 0.95rem;
            font-weight: 600;
        }

        .category-pill {
            background-color: #eeeeee;
            color: #444;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <header class="mb-5">
            <h1 class="fw-bold mb-1">Upcoming Events</h1>
            <p class="text-muted">Discover the best live experience near you.</p>
        </header>

        @foreach($eventsByCategory as $category => $events)
            <section class="mb-5">
                <div class="category-header d-flex justify-content-between align-items-end mb-4">
                    <h2 class="h3 fw-bold mb-0">{{ $category }}</h2>
                    <a href="#" class="text-decoration-none fw-semibold" style="color: #026cdf;">View All</a>
                </div>

                <div class="row g-4">
                    @foreach($events as $event)
                        <div class="col-12 col-md-6 col-lg-4">
                            <article class="card h-100 event-card bg-white">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="date-container">
                                            <div class="date-month">{{ \Carbon\Carbon::parse($event->datetime)->format('M') }}</div>
                                            <div class="date-day">{{ \Carbon\Carbon::parse($event->datetime)->format('d') }}</div>
                                        </div>
                                        <span class="badge category-pill px-2 py-1">
                                            {{ $event->category->name ?? 'Event' }}
                                        </span>
                                    </div>

                                    <h3 class="event-title mb-1">{{ $event->title }}</h3>
                                    <p class="venue-info mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-geo-alt-fill me-1" viewBox="0 0 16 16">
                                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                                        </svg>
                                        {{ $event->venue->name ?? 'TBA' }} — {{ $event->venue->city ?? 'Location TBA' }}
                                    </p>

                                    <p class="small text-muted mb-4">
                                        {{ \Carbon\Carbon::parse($event->datetime)->format('D • H:i') }} • {{ $event->duration }} min
                                    </p>

                                    <div class="mt-auto d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="text-muted small">From</div>
                                            <div class="price-text">€{{ number_format($event->entry_price, 2) }}</div>
                                        </div>
                                    <form action="{{ route('tickets.ticketstore') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                                        <input type="hidden" name="entry_price" value="{{ $event->entry_price }}">
                                        <input type="hidden" name="rank" value="Standard">

                                        <button type="submit" class="btn btn-primary btn-ticketmaster">
                                            Find Tickets
                                        </button>
                                    </form>
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