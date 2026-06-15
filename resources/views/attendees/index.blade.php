<x-base-layout>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Inter', sans-serif; background-color: #f5f5f7; }
            .admin-card { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
            .table thead th { 
                background-color: #f8f9fa; 
                text-transform: uppercase; 
                font-size: 0.75rem; 
                letter-spacing: 0.5px; 
                font-weight: 700; 
                color: #6f7287;
                border-top: none;
                padding: 1rem;
            }
            .table tbody td { padding: 1rem; vertical-align: middle; font-size: 0.9rem; }
            .user-name { font-weight: 600; color: #2d2d2d; }
            .ticket-badge { 
                background-color: #e8f2ff; 
                color: #026cdf; 
                padding: 4px 8px; 
                border-radius: 6px; 
                font-weight: 600; 
                font-size: 0.8rem;
            }
            .btn-delete-mini { 
                color: #dc3545; 
                background: none; 
                border: none; 
                font-size: 0.8rem; 
                font-weight: 600;
                padding: 0;
                margin-left: 10px;
            }
            .btn-delete-mini:hover { text-decoration: underline; }
            .ticket-item { 
                display: flex; 
                justify-content: space-between; 
                align-items: center;
                background: #fff;
                border: 1px solid #eee;
                padding: 6px 10px;
                border-radius: 8px;
                margin-bottom: 5px;
            }
        </style>
    </head>

    <div class="container py-5">
        <header class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="fw-bold h3 mb-1">User Management</h1>
                <p class="text-muted small">Overview of all registered attendees and their tickets</p>
            </div>
        </header>

        <div class="admin-card bg-white overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Contact Information</th>
                            <th class="text-center">Tickets</th>
                            <th>Active Reservations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="text-muted">#{{ $user->id }}</td>
                                <td>
                                    <div class="user-name">{{ $user->name }}</div>
                                    <div class="small text-muted">ID: {{ $user->ticket_number }}</div>
                                </td>
                                <td>
                                    <div class="fw-medium">{{ $user->email }}</div>
                                    <div class="small text-muted">{{ $user->phonenumber }}</div>
                                </td>
                                <td class="text-center">
                                    <span class="ticket-badge">{{ $user->tickets->count() }}</span>
                                </td>
                                <td style="min-width: 300px;">
                                    @forelse($user->tickets as $ticket)
                                        <div class="ticket-item shadow-sm">
                                            <span class="small fw-bold text-dark">
                                                ID: {{ $ticket->id }} 
                                                <span class="text-muted fw-normal ms-1">
                                                    @if($ticket->event) ({{ $ticket->event->name }}) @endif
                                                </span>
                                            </span>
                                            
                                            <form method="POST" action="{{ route('attendee.ticket.destroy', $ticket->id) }}" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-delete-mini" onclick="return confirm('Ticket annuleren?')">
                                                    Afmelden
                                                </button>
                                            </form>
                                        </div>
                                    @empty
                                        <span class="text-muted small italic">No active tickets</span>
                                    @endforelse
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    No users found in the database.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-base-layout>