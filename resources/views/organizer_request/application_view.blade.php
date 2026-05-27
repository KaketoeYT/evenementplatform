<x-base-layout>
    <div class="max-w-[1400px] mx-auto px-6 py-12">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-10">
            <div>
                <h1 class="text-4xl font-black text-slate-950 tracking-tight">
                    Organisator Aanvragen
                </h1>

                <p class="text-slate-500 mt-2 text-lg">
                    Overzicht van alle binnengekomen aanvragen.
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
                                    Organisatie
                                </th>

                                <th
                                    class="text-left px-6 py-5 text-xs font-black uppercase tracking-widest text-slate-500">
                                    Evenement Type
                                </th>

                                <th
                                    class="text-left px-6 py-5 text-xs font-black uppercase tracking-widest text-slate-500">
                                    Website
                                </th>

                                <th
                                    class="text-left px-6 py-5 text-xs font-black uppercase tracking-widest text-slate-500">
                                    Ervaring
                                </th>

                                <th
                                    class="text-left px-6 py-5 text-xs font-black uppercase tracking-widest text-slate-500">
                                    Datum
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

                                    <!-- Organisatie -->
                                    <td class="px-6 py-6">
                                        <div class="font-bold text-slate-900">
                                            {{ $request->organization_name }}
                                        </div>

                                        <div class="text-sm text-slate-500 mt-1 line-clamp-2">
                                            {{ Str::limit($request->motivation, 80) }}
                                        </div>
                                    </td>

                                    <!-- Event Type -->
                                    <td class="px-6 py-6">
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-sm font-semibold">
                                            {{ $request->event_type }}
                                        </span>
                                    </td>

                                    <!-- Website -->
                                    <td class="px-6 py-6">
                                        @if ($request->website)
                                            <a href="{{ $request->website }}" target="_blank"
                                                class="text-blue-600 hover:text-blue-800 font-medium underline underline-offset-4">
                                                Bekijken
                                            </a>
                                        @else
                                            <span class="text-slate-400">Geen website</span>
                                        @endif
                                    </td>

                                    <!-- Ervaring -->
                                    <td class="px-6 py-6 max-w-xs">
                                        <p class="text-slate-600 text-sm leading-relaxed">
                                            {{ Str::limit($request->experience, 90) ?: 'Geen ervaring ingevuld' }}
                                        </p>
                                    </td>

                                    <!-- Datum -->
                                    <td class="px-6 py-6 text-slate-500 text-sm whitespace-nowrap">
                                        {{ $request->created_at->format('d M Y') }}
                                    </td>

                                    <!-- Acties -->
                                    <td class="px-6 py-6">
                                        <div class="flex items-center justify-end gap-3">

                                            <form method="POST"
                                                action="{{ route('organizer_request.destroy', $request) }}"
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

                                    {{-- Show  --}}
                                    <td class="p-4">
                                        <a href="{{ route('organizer_request.show', $request->id) }}"
                                            class="text-blue-600 hover:underline">
                                            Bekijken
                                        </a>
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
                        Er zijn momenteel nog geen organisator aanvragen binnengekomen.
                    </p>
                </div>

            @endif

        </div>
    </div>
</x-base-layout>
