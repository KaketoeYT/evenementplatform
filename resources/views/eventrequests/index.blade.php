<x-base-layout>
    <div class="max-w-[1400px] mx-auto px-6 py-12">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-10">
            <div>
                <h1 class="text-4xl font-black text-slate-950 tracking-tight">
                    Eventaanvragen
                </h1>

                <p class="text-slate-500 mt-2 text-lg">
                    Overzicht van alle binnengekomen event aanvragen.
                </p>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div
                class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-5 rounded-2xl mb-8 flex items-center gap-3">
                <span class="text-2xl">✓</span>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Table Card -->
        <div class="bg-white border border-slate-100 rounded-[2rem] overflow-hidden shadow-xl shadow-slate-100/50">

            @if ($requests->count())
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th
                                    class="text-left px-6 py-5 text-xs font-black uppercase tracking-widest text-slate-500">
                                    Naam
                                </th>

                                <th
                                    class="text-left px-6 py-5 text-xs font-black uppercase tracking-widest text-slate-500">
                                    Omschrijving
                                </th>

                                <th
                                    class="text-left px-6 py-5 text-xs font-black uppercase tracking-widest text-slate-500">
                                    Gebruiker
                                </th>

                                <th
                                    class="text-left px-6 py-5 text-xs font-black uppercase tracking-widest text-slate-500">
                                    Locatie
                                </th>

                                <th
                                    class="text-right px-6 py-5 text-xs font-black uppercase tracking-widest text-slate-500">
                                    Acties
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @foreach ($requests as $request)
                                <tr class="hover:bg-slate-50 transition-all">

                                    <!-- Naam -->
                                    <td class="px-6 py-6">
                                        <div class="font-bold text-slate-900">
                                            {{ $request->name }}
                                        </div>
                                    </td>

                                    <!-- Omschrijving -->
                                    <td class="px-6 py-6 max-w-xs">
                                        <p class="text-slate-600 text-sm leading-relaxed">
                                            {{ Str::limit($request->description, 90) ?: 'Geen omschrijving ingevuld' }}
                                        </p>
                                    </td>

                                    <!-- Gebruiker -->
                                    <td class="px-6 py-6 text-slate-500 text-sm whitespace-nowrap">
                                        {{ $request->user->name ?? 'Onbekend' }}
                                    </td>

                                    <!-- Locatie -->
                                    <td class="px-6 py-6 text-slate-500 text-sm whitespace-nowrap">
                                        {{ $request->venue->name ?? 'Geen locatie' }}
                                    </td>

                                    <!-- Acties -->
                                    <td class="px-6 py-6">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('eventrequests.show', $request->id) }}"
                                                class="text-blue-600 hover:underline font-medium">
                                                Bekijken
                                            </a>

                                            <form method="POST" action="{{ route('eventrequests.destroy', $request) }}"
                                                onsubmit="return confirm('Weet je zeker dat je deze aanvraag wilt verwijderen?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="px-4 py-2 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 font-semibold transition-all">
                                                    Verwijderen
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            @else
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center py-24 px-6 text-center">
                    <div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center text-4xl mb-6">
                        📭
                    </div>

                    <h2 class="text-2xl font-bold text-slate-900 mb-2">
                        Geen aanvragen gevonden
                    </h2>

                    <p class="text-slate-500 max-w-md">
                        Er zijn momenteel nog geen event aanvragen binnengekomen.
                    </p>
                </div>

            @endif

        </div>
    </div>
</x-base-layout>
