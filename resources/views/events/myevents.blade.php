<x-base-layout>
<div class="max-w-6xl mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Mijn Gereserveerde Events</h1>

    @if($events->isEmpty())
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded shadow-sm">
            <p class="text-yellow-700">Je hebt momenteel nog geen tickets voor aankomende events.</p>
            <a href="/events" class="text-yellow-800 font-bold underline mt-2 inline-block">Bekijk alle events</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($events as $event)
                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 flex flex-col justify-between">
                    
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                    @endif

                    <div class="p-6 flex-grow">
                        <span class="text-sm font-semibold text-indigo-600 uppercase tracking-wider block mb-1">
                            {{ \Carbon\Carbon::parse($event->start_time)->translatedFormat('d F Y - H:i') }}
                        </span>

                        <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $event->title }}</h2>
                        
                        <p class="text-gray-600 text-sm mb-4 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $event->location ?? 'Locatie nog onbekend' }}
                        </p>

                        <p class="text-gray-700 text-sm line-clamp-3">
                            {{ Str::limit($event->description, 100) }}
                        </p>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs text-gray-500">
                            Ticket: <span class="font-mono font-bold text-gray-700">{{ $event->pivot->ticket_code ?? 'Geldig' }}</span>
                        </span>
                        <a href="{{ route('events.show', $event->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                            Bekijk Event
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
</x-base-layout>