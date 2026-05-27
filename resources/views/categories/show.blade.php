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

            /* Content Kaart styling */
            .category-detail-card {
                border: none;
                border-radius: 16px;
            }

            /* Compacte Event Rij styling */
            .event-list-item {
                border: 1px solid #e9ecef;
                border-radius: 12px;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
                background: #ffffff;
            }

            .event-list-item:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(0,0,0,0.05) !important;
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

            /* Sticky Sidebar voor Categorie Info */
            .category-sidebar {
                background: #ffffff;
                border-radius: 16px;
                border: 1px solid #e9ecef;
                position: sticky;
                top: 40px;
                z-index: 10;
            }

            .stat-large {
                font-size: 2.25rem;
                font-weight: 700;
                color: #212529;
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

    <div class="container py-5">
        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 p-3 rounded-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Navigatie bovenin --}}
        <div class="mb-4">
            <a href="{{ route('categories.index') }}" class="text-decoration-none small fw-bold d-inline-flex align-items-center" style="color: #026cdf;">
                <i class="bi bi-arrow-left me-2"></i> BACK TO CATEGORIES
            </a>
        </div>

        <div class="row g-4">
            {{-- Linker Kant: Categorie info & Gekoppelde Evenementen --}}
            <div class="col-lg-8">
                
                <div class="category-detail-card shadow-sm p-4 p-md-5 bg-white mb-4">
                    {{-- Categorie Naam --}}
                    <h1 class="display-5 fw-bold mb-3 text-dark">{{ $category->name }}</h1>

                    {{-- Beschrijving --}}
                    <p class="text-secondary mb-0" style="line-height: 1.8; font-size: 1.05rem;">
                        {{ $category->description ?? 'No specific description available for this category. Browse the listed events below to see what is happening.' }}
                    </p>

                    {{-- Beheeropties voor Admins / Organizers --}}
                    @auth
                        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'organizer')
                            <div class="mt-4 pt-4 border-top d-flex gap-3">
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-outline-secondary px-4 rounded-3 fw-medium">
                                    <i class="bi bi-pencil me-2"></i>Edit Category
                                </a>
                                <form method="POST" action="{{ route('categories.destroy', $category->id) }}" onsubmit="return confirm('Are you sure you want to delete this category? All linked events will lose this category reference.');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger px-4 rounded-3 fw-medium">
                                        <i class="bi bi-trash me-2"></i>Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>

                {{-- Lijst met Evenementen binnen deze categorie --}}
                <h3 class="fw-bold mb-4 mt-5 d-flex align-items-center">
                    <i class="bi bi-calendar-event me-2 text-primary"></i> Events in this Category
                </h3>

                <div class="d-flex flex-column gap-3">
                    @forelse($category->events ?? [] as $event)
                        <div class="event-list-item p-4 shadow-sm">
                            <div class="row align-items-center g-3">
                                <div class="col-md-8">
                                    <h4 class="h5 fw-bold text-dark mb-2">{{ $event->title }}</h4>
                                    <div class="d-flex flex-wrap gap-3 text-muted small">
                                        <span>
                                            <i class="bi bi-calendar3 me-1"></i> 
                                            {{ \Carbon\Carbon::parse($event->datetime)->format('D, M j, Y • H:i') }}
                                        </span>
                                        <span>
                                            <i class="bi bi-geo-alt-fill me-1"></i> 
                                            {{ $event->venue->name ?? 'TBA' }} ({{ $event->venue->city ?? 'TBA' }})
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-end d-flex justify-content-between align-items-center justify-content-md-end gap-3">
                                    <div>
                                        <div class="text-muted small-label" style="font-size: 0.75rem;">FROM</div>
                                        <div class="fw-bold text-dark">€{{ number_format($event->entry_price, 2, ',', '.') }}</div>
                                    </div>
                                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-sm btn-primary px-3 rounded-2">
                                        Tickets <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- Geen evenementen gevonden placeholder --}}
                        <div class="card border-0 shadow-sm p-5 text-center bg-white rounded-3">
                            <div class="text-muted mb-3 fs-2">
                                <i class="bi bi-calendar-x"></i>
                            </div>
                            <h5 class="fw-bold text-secondary">No upcoming events</h5>
                            <p class="text-muted small mb-0">There are currently no scheduled events listed under this category.</p>
                        </div>
                    @endforelse
                </div>

            </div>

            {{-- Rechter Kant: Categorie Statistieken / Quick Info Sidebar --}}
            <div class="col-lg-4">
                <div class="category-sidebar shadow-sm p-4 sticky-top" style="top: 20px;">
                    
                    {{-- Totaal aantal events teller --}}
                    <div class="mb-4 pb-4 border-bottom border-light">
                        <div class="info-label mb-1">Total Active Events</div>
                        <div class="stat-large">
                            {{ $category->events_count ?? count($category->events ?? []) }}
                        </div>
                    </div>

                    {{-- Extra metadata om de sidebar mooi op te vullen --}}
                    <div class="d-flex flex-column gap-4">
                        <div class="d-flex align-items-start gap-3">
                            <div class="info-icon-box">
                                <i class="bi bi-folder2-open"></i>
                            </div>
                            <div>
                                <div class="info-label">Type</div>
                                <div class="info-value">Event Classification</div>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <div class="info-icon-box">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div>
                                <div class="info-label">Status</div>
                                <div class="info-value text-success">Verified Category</div>
                            </div>
                        </div>
                    </div>

                    {{-- CTA om terug naar alle evenementen te gaan --}}
                    <div class="mt-4 pt-2">
                        <a href="{{ route('events.index') }}" class="btn btn-outline-primary w-100 py-2 rounded-3 fw-medium">
                            <i class="bi bi-search me-2"></i>Explore All Events
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-base-layout>