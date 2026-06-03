<x-base-layout>
    <section class="bg-slate-50 border-b border-slate-200 py-20 lg:py-32 w-full">
        <div class="max-w-[1150px] mx-auto px-6">
            <h1 class="text-5xl lg:text-7xl font-extrabold text-slate-900 leading-tight mb-6">
                Vind je volgende <br><span class="text-blue-600">onvergetelijke ervaring.</span>
            </h1>
            <p class="text-xl text-slate-600 mb-10 max-w-xl">
                Ontdek en reserveer je plek voor de meest populaire evenementen van dit moment.
            </p>
            <div class="flex gap-4">
                <a href="{{ route('events.index') }}"
                    class="px-8 py-4 bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-200">Bekijk
                    Events</a>
            </div>
        </div>
    </section>

    {{-- De rest van de content: In een container voor de juiste uitlijning --}}
    <div class="max-w-[1150px] mx-auto px-6 py-12">

        {{-- Populaire Events --}}
        <section id="events" class="mb-20">
            <h2 class="text-3xl font-bold mb-8 text-slate-900">Populaire Events</h2>

            {{-- Grid: Altijd 3 naast elkaar op desktop --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($featuredEvents as $event)
                    {{-- Voeg de class 'card' toe voor het hover-effect uit je layout --}}
                    <article class="card flex flex-col">
                        <div class="flex justify-between items-start mb-6">
                            <div class="text-center bg-slate-50 rounded-xl p-2 min-w-[55px]">
                                <span class="block text-[10px] font-black text-blue-600 uppercase leading-none mb-1">
                                    {{ \Carbon\Carbon::parse($event->datetime)->format('M') }}
                                </span>
                                <span class="text-xl font-bold text-slate-900">
                                    {{ \Carbon\Carbon::parse($event->datetime)->format('d') }}
                                </span>
                            </div>
                            <span class="badge">
                                {{ $event->category->name ?? 'Event' }}
                            </span>
                        </div>

                        <h3 class="title">{{ $event->title }}</h3>

                        {{-- Optioneel: voeg de meta info toe voor de locatie zoals in je index --}}
                        <p class="meta mb-4">
                            {{ $event->venue->name ?? 'TBA' }} — {{ $event->venue->city ?? 'Location TBA' }}
                        </p>

                        <div class="mt-auto pt-6 border-t border-slate-100 flex justify-between items-center">
                            <div>
                                <span class="block text-[10px] text-slate-400 uppercase font-bold">Vanaf</span>
                                <span
                                    class="text-lg font-black italic">€{{ number_format($event->entry_price, 2) }}</span>
                            </div>
                            <a href="{{ route('events.show', $event->id) }}"
                                class="bg-slate-900 text-white px-5 py-2 rounded-xl text-sm font-bold shadow-sm hover:bg-slate-800 transition-colors">
                                Tickets
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        {{-- Organizer request --}}
        @auth
            <section class="bg-blue-600 rounded-[2rem] p-12 text-white overflow-hidden relative">
                <div class="relative z-10 max-w-2xl">
                    <h2 class="text-4xl font-bold mb-6">Tickets regelen was nog nooit zo makkelijk.</h2>
                    <p class="text-blue-100 text-lg mb-8">Wij brengen fans en organisatoren samen op een platform dat werkt
                        zoals jij dat wilt. Snel, veilig en zonder gedoe.</p>
                    <a href="{{ route('organizer_request.index') }}"
                        class="inline-block bg-white text-blue-600 px-8 py-4 rounded-2xl font-bold hover:bg-blue-50 transition-colors">Word
                        organisator op Eventify</a>
                </div>
                <div class="absolute -right-20 -bottom-20 text-[300px] font-black text-white opacity-5 select-none">◈</div>
            </section>
        @endauth

    </div>
</x-base-layout>

