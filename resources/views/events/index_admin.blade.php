<x-base-layout>

    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f5f5f7;
            }

            .admin-card {
                border: none;
                border-radius: 12px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
                background: white;
            }

            .table thead th {
                background-color: #f8f9fa;
                text-transform: uppercase;
                font-size: 0.7rem;
                letter-spacing: 0.8px;
                font-weight: 700;
                color: #6f7287;
                padding: 1.25rem 1rem;
                border: none;
            }

            .table tbody td {
                padding: 1.25rem 1rem;
                vertical-align: middle;
                font-size: 0.9rem;
                border-bottom: 1px solid #f0f0f0;
            }

            .event-title-cell {
                font-weight: 600;
                color: #026cdf;
            }

            .price-tag {
                font-weight: 600;
                color: #2d2d2d;
            }

            .status-badge {
                padding: 6px 12px;
                border-radius: 20px;
                font-size: 0.75rem;
                font-weight: 700;
                border: none;
                width: 100%;
                text-transform: uppercase;
            }

            .btn-action {
                font-weight: 600;
                font-size: 0.85rem;
                text-decoration: none;
                transition: 0.2s;
            }

            .btn-edit {
                color: #026cdf;
            }

            .btn-edit:hover {
                color: #0151a8;
                text-decoration: underline;
            }

            .text-timestamp {
                font-size: 0.75rem;
                color: #a1a1a1;
                font-family: monospace;
            }
        </style>
    </head>

    <div class="container py-5">
        <header class="mb-4 d-flex justify-content-between align-items-end">
            <div>
                <h1 class="fw-bold h3 mb-1">Event Management</h1>
                <p class="text-muted small mb-0">Manage all events, ticket prices and registrations.</p>
            </div>
            <a href="{{ route('events.create') }}" class="btn btn-primary px-4 fw-bold"
                style="background-color: #026cdf; border: none;">
                + New Event
            </a>
        </header>

        <div class="admin-card overflow-hidden">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Event Details</th>
                            <th>Location & Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                            <th>Timestamps</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                            <tr>
                                <td class="text-muted">#{{ $event->id }}</td>
                                <td>
                                    <div class="event-title-cell">{{ $event->title }}</div>
                                    <div class="small text-muted">
                                        {{ \Carbon\Carbon::parse($event->datetime)->format('d M Y • H:i') }}
                                        ({{ $event->duration }} min)
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-medium">{{ $event->venue->name ?? 'TBA' }}</div>
                                    <span
                                        class="badge bg-light text-dark border fw-normal">{{ $event->category->name ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <div class="price-tag">€{{ number_format($event->entry_price, 2, ',', '.') }}</div>
                                </td>
                                <td style="min-width: 160px;">
                                    <form method="POST" action="{{ route('events.toggleRegistration', $event) }}">
                                        @csrf
                                        <button type="submit"
                                            class="status-badge {{ $event->registration_closed ? 'bg-danger text-white' : 'bg-success text-white' }}">
                                            {{ $event->registration_closed ? 'Closed' : 'Open' }}
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        <a href="{{ route('events.edit', $event->id) }}"
                                            class="btn-action btn-edit">Edit</a>

                                        <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                                            onsubmit="return confirm('Delete?');">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="btn-action p-0 border-0 bg-transparent text-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-timestamp">C: {{ $event->created_at->format('d/m/y H:i') }}</div>
                                    <div class="text-timestamp">U: {{ $event->updated_at->format('d/m/y H:i') }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-base-layout>
