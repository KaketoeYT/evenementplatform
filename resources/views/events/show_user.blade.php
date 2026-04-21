<x-base-layout>
    <div class="container mx-auto px-4 py-8 max-w-6xl bg-white rounded-lg shadow-md">
        <h1 id="event-{{ $event->id }}" class="text-4xl font-bold mb-6 text-gray-900">
            {{ $event->title }}
        </h1>

        {{-- Tickets Table --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left">Ticket Nummer</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Naam</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Rang</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Prijs</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2">{{ $ticket->ticket_number }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $ticket->user->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $ticket->user->email }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $ticket->rank }}</td>
                            <td class="border border-gray-300 px-4 py-2">€ {{ number_format($ticket->price, 2, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                                Geen tickets voor dit evenement
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-base-layout>
