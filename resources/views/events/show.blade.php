<x-base-layout>
    <div class="container mx-auto px-4 py-8 max-w-3xl bg-white rounded-lg shadow-md">
        {{-- Header --}}
        <h1 class="text-4xl font-bold mb-4 text-gray-900">
            {{ $event->titel }}
        </h1>

        {{-- Attributes --}}
        <div class="space-y-2 mb-6">
            <p><span class="font-semibold">Datumtijd:</span> {{ \Carbon\Carbon::parse($event->datumtijd)->format('d-m-Y H:i') }}</p>
            <p><span class="font-semibold">Duur:</span> {{ $event->duration }} min </p>
            <p><span class="font-semibold">Beschrijving:</span> {{ $event->description ?? '-' }}</p>
            <p><span class="font-semibold">Entree prijs:</span> € {{ number_format($event->entry_price, 2, ',', '.') }}</p>
        </div>

{{-- Actions --}}
@if(auth()->check() && auth()->user()->role === 'organisator')
    <div class="flex space-x-4 mb-6">
        <a href="{{ route('events.edit', $event->id) }}"
            class="inline-block text-indigo-600 hover:text-indigo-800 font-medium transition-colors duration-200">
            Bewerken
        </a>

        <form method="POST" action="{{ route('events.destroy', $event->id) }}" 
              onsubmit="return confirm('Weet je zeker dat je dit evenement wilt verwijderen?');">
            @csrf
            @method('DELETE')

            <button type="submit"
                class="text-red-600 hover:text-red-800 font-medium transition-colors duration-200">
                Verwijderen
            </button>
        </form>
    </div>
@endif

        {{-- Back link --}}
        <a href="{{ route('events.index') }}"
            class="inline-block mt-4 text-indigo-600 hover:text-indigo-800 font-medium transition-colors duration-200">
            ← Terug naar alle evenementen
        </a>
    </div>
</x-base-layout>
