<x-base-layout>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f8f9fa;
            }
            .form-card {
                border: none;
                border-radius: 16px;
                background: #ffffff;
            }
            .form-control:focus {
                border-color: #026cdf;
                box-shadow: 0 0 0 0.25rem rgba(2, 108, 223, 0.15);
            }
            .btn-save {
                background-color: #026cdf;
                color: white;
                font-weight: 600;
                transition: background-color 0.2s ease;
            }
            .btn-save:hover {
                background-color: #0151a8;
                color: white;
            }
        </style>
    </head>

    <div class="container py-5">
        {{-- Navigatie bovenin --}}
        <div class="mb-4">
            <a href="{{ route('categories.index') }}" class="text-decoration-none small fw-bold d-inline-flex align-items-center" style="color: #026cdf;">
                <i class="bi bi-arrow-left me-2"></i> BACK TO CATEGORIES
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                
                {{-- Formulier Kaart --}}
                <div class="form-card shadow-sm p-4 p-md-5">
                    <header class="mb-4">
                        <h1 class="h3 fw-bold text-dark mb-1">Create New Category</h1>
                        <p class="text-muted small">Add a new category to classify upcoming events.</p>
                    </header>

                    {{-- Formulier --}}
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf

                        {{-- Category Name Input --}}
                        <div class="mb-4">
                            <label for="name" class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">
                                Category Name
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                placeholder="e.g., Music, Sports, Workshops" 
                                value="{{ old('name') }}" 
                                required 
                                autofocus
                            >
                            
                            {{-- Validatie Foutmelding --}}
                            @error('name')
                                <div class="invalid-feedback mt-2">
                                    <i class="bi bi-exclamation-circle-fill me-1"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Actie Knoppen --}}
                        <div class="d-flex gap-3 pt-2">
                            <a href="{{ route('categories.index') }}" class="btn btn-lg btn-light w-50 fw-medium text-secondary rounded-3 fs-6">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-lg btn-save w-50 rounded-3 fs-6 shadow-sm">
                                <i class="bi bi-plus-lg me-1"></i> Save Category
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-base-layout>