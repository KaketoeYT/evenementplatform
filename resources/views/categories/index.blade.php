<x-base-layout>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Categories</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
        
        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f8f9fa;
            }
            .category-card {
                transition: transform 0.2s ease, box-shadow 0.2s ease;
                border: 1px solid #e9ecef;
            }
            .category-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
            }
            .icon-wrapper {
                width: 48px;
                height: 48px;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #e7f1ff;
                color: #0d6efd;
                border-radius: 12px;
            }
        </style>
    </head>

    <body>
        <div class="container py-5">

            <!-- Flash Notificaties -->
            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-green-800 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-red-800 shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Header -->
            <header class="mb-5 d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="fw-bold mb-1">Categories</h1>
                    <p class="text-muted mb-0">Browse events by their category and find what interests you.</p>
                </div>
                <!-- Optioneel: Knop om categorie aan te maken als de gebruiker admin is -->
                @if(auth()->user()?->role === 'admin')
                <a href="{{ route('categories.create') }}" class="btn btn-primary px-4">
                    + New Category
                </a>
            @endif
            </header>

            <!-- Categorieën Grid -->
            <div class="row g-4">
                @forelse ($categories ?? [] as $category)
                    <div class="col-12 col-md-6 col-lg-4">
                        <article class="card h-100 category-card bg-white shadow-sm">
                            <div class="card-body p-4 d-flex flex-col justify-content-between">
                                <div>
                                    <!-- Categorie Icoon (Standaard Map Icoon, aanpasbaar) -->
                                    <div class="icon-wrapper mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-grid-fill" viewBox="0 0 16 16">
                                            <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zm8 0A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 2.5zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5zm8 0A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 15 10.5v3a1.5 1.5 0 0 1-1.5 15h-3a1.5 1.5 0 0 1-1.5-1.5z"/>
                                        </svg>
                                    </div>

                                    <!-- Categorie Titel -->
                                    <h3 class="h5 fw-bold text-dark mb-2">{{ $category->name }}</h3>
                                    
                                    <!-- Categorie Beschrijving (indien aanwezig in je database) -->
                                    <p class="text-muted small mb-4">
                                        {{ Str::limit($category->description ?? 'Explore all upcoming events listed under this category.', 90) }}
                                    </p>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mt-auto pt-2 border-top border-light">
                                    <!-- Aantal evenementen teller -->
                                    <span class="badge bg-light text-primary px-2 py-2 font-medium">
                                        {{ $category->events_count ?? count($category->events ?? []) }} Events
                                    </span>

                                    <!-- Actie knop -->
                                    <a href="{{ route('categories.show', $category->id) }}" class="btn btn-sm btn-outline-primary px-3">
                                        View Events
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <!-- Placeholder als er geen categorieën zijn -->
                    <div class="col-12 text-center py-5">
                        <div class="text-muted mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-folder-x" viewBox="0 0 16 16">
                                <path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181L15.546 8H14.54l.269-2.22A1 1 0 0 0 13.81 5H9.828a3 3 0 0 1-2.12-.879l-.83-.828A1 1 0 0 0 6.172 3H2.5a1 1 0 0 0-1 .981L1.546 8H.54zM11.854 10.146a.5.5 0 0 0-.707.708L12.293 12l-1.146 1.146a.5.5 0 0 0 .707.708L13 12.707l1.146 1.147a.5.5 0 0 0 .708-.708L13.707 12l1.147-1.146a.5.5 0 0 0-.707-.708L13 11.293z"/>
                            </svg>
                        </div>
                        <h3 class="h5 fw-bold text-muted">No categories found</h3>
                        <p class="text-muted small">There are currently no event categories available.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </body>

    </html>
</x-base-layout>