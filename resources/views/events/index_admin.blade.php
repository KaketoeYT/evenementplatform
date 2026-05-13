<x-base-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Events</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>DateTime</th>
                    <th>Duration (minutes)</th>
                    <th>Description</th>
                    <th>Entry Price</th>
                    <th>Category</th>
                    <th>Venue</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>edit</th>
                    <th>delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                <tr>
                    <td>{{ $event->id }}</td>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->datetime }}</td>
                    <td>{{ $event->duration }}</td>
                    <td>{{ $event->description }}</td>
                    <td>${{ number_format($event->entry_price, 2) }}</td>
                    <td>{{ $event->category->name ?? 'N/A' }}</td>
                    <td>{{ $event->venue->name ?? 'N/A' }}</td>
                    <td>{{ $event->created_at }}</td>
                    <td>{{ $event->updated_at }}</td>
                    <td><a href="{{ route('events.edit', $event->id) }}">bewerk</a></td>
                    <td>
                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je dit evenement wilt verwijderen?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link p-0 text-danger">verwijder</button>
                        </form>
                    </td>
                    <td>
                            <form method="POST" action="{{ route('events.toggleRegistration', $event) }}">
                                    @csrf

                                    <button type="submit"
                                        class="px-4 py-2 text-sm font-semibold rounded-lg transition
                                        {{ $event->registration_closed 
                                            ? 'bg-green-600 hover:bg-green-700 text-white' 
                                            : 'bg-red-600 hover:bg-red-700 text-white' }}">

                                        {{ $event->registration_closed ? 'Open aanmelding' : 'Sluit aanmelding' }}
                                    </button>
                                </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
</x-base-layout>