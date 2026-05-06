<x-base-layout>
    @if (session('info'))
        <div class="mb-4 rounded-lg bg-green-50 border border-red-200 px-4 py-3 text-green-800 shadow-sm">
                {{ session('info') }}
            </div>
    @endif
    <div class="container mx-auto px-4 py-8 max-w-3xl bg-white rounded-lg shadow-md">
        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-green-800 shadow-sm">
                {{ session('success') }}
            </div>
        @endif
        @if (@session('error'))
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-red-800 shadow-sm">
                {{ session('error') }}
            </div>
        @endif
        <h1 class="text-4xl font-bold mb-4 text-gray-900">
            {{ $event->titel }}
        </h1>

        {{-- Attributes --}}
        <div class="space-y-2 mb-6">
            <p><span class="font-semibold">Title:</span> {{ $event->title}}</p>
            <p><span class="font-semibold">Venue:</span> {{ $event->venue->name ?? 'TBA' }} -
                {{ $event->venue->city ?? 'Location TBA' }}</p>
            <p><span class="font-semibold">Date-time:</span>
                {{ \Carbon\Carbon::parse($event->datetime)->format('d-m-Y H:i') }}</p>
            <p><span class="font-semibold">Duration:</span> {{ $event->duration }} min </p>
            <p><span class="font-semibold">Description:</span> {{ $event->description ?? '-' }}</p>
            <p><span class="font-semibold">Entry Price:</span> € {{ number_format($event->entry_price, 2, ',', '.') }}
            </p>
        </div>

        {{-- Actions --}}
        @if (auth()->check() && auth()->user()->role === 'organizer')
            <div class="flex space-x-4 mb-6">
                <a href="{{ route('events.edit', $event->id) }}"
                    class="inline-block text-indigo-600 hover:text-indigo-800 font-medium transition-colors duration-200">
                    Edit
                </a>

                <form method="POST" action="{{ route('events.destroy', $event->id) }}"
                    onsubmit="return confirm('Weet je zeker dat je dit evenement wilt verwijderen?');">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="text-red-600 hover:text-red-800 font-medium transition-colors duration-200">
                        Delete
                    </button>
                </form>
            </div>
        @endif
            @if($event->tickets_count >= $event->venue->capacity)
            {{-- Knop voor de wachtrij als het vol is --}}
            <form action="{{ route('event.queue', $event->id) }}" method="POST">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                <button type="submit" class="btn btn-warning">
                    Meld je aan voor de wachtrij
                </button>
            </form>
        @else
            <form action="{{ route('tickets.ticketstore') }}" method="POST">
            @csrf
            <input type="hidden" name="event_id" value="{{ $event->id }}">
            <input type="hidden" name="rank" value="standard">
            <input type="hidden" name="entry_price" value="{{ $event->entry_price }}">

            <button type="submit" class="btn btn-primary btn-ticketmaster">
                Register Now
            </button>
            @endif
        </form>>
        {{-- Back link --}}
        <a href="{{ redirect()->back()->getTargetUrl() }}"
            class="inline-block mt-4 text-indigo-600 hover:text-indigo-800 font-medium transition-colors duration-200">
            ← Back to all events
        </a>
    </div>
</x-base-layout>

