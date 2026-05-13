<x-base-layout>

    <main class="container">
        <!-- 1. Welcome stukje tekst -->
        <section class="welcome-section">
            <h1 class="fw-bold display-4 mb-3">Welkom bij Tickets</h1>
            <p class="text-muted fs-5">Ontdek en reserveer je plek voor de meest populaire evenementen van dit moment.
            </p>
        </section>

        <!-- 2. De 3 meest populaire events -->
        <section class="pb-5">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($featuredEvents as $event)
                    <div class="col">
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
                                        <div class="price-text">€{{ number_format($event->entry_price, 2) }}
                                        </div>
                                    </div>

                                    </form>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('events.show', $event->id) }}"
                                            class="btn btn-outline-secondary">View details</a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </section>
    </main>
</x-base-layout>

