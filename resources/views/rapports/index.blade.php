<x-base-layout>
    <div class="max-w-6xl mx-auto mt-10 p-6 space-y-8">

        <h1 class="text-3xl font-bold text-gray-900">Rapports</h1>

        {{-- TOP STATS --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

            <div class="bg-white rounded-xl shadow p-6 text-center border border-gray-100">
                <p class="text-4xl font-bold text-indigo-600">{{ $totalEvents }}</p>
                <p class="text-gray-500 mt-2 text-sm font-medium">Totaal evenementen</p>
            </div>

        </div>

        {{-- FILTER (UI READY) --}}
        <div class="bg-white rounded-xl shadow p-6 border border-gray-100 flex justify-between items-center">

            <h2 class="text-xl font-bold text-gray-800">Filter op periode</h2>

            <form method="GET" class="flex gap-3 items-center">

                <select name="period" class="border rounded px-3 py-2 text-sm">
                    <option value="all" @selected(request('period') == 'all')>Alles</option>
                    <option value="today" @selected(request('period') == 'today')>Vandaag</option>
                    <option value="week" @selected(request('period') == 'week')>Deze week</option>
                    <option value="month" @selected(request('period') == 'month')>Deze maand</option>
                </select>

                <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">
                    Filter
                </button>

            </form>

        </div>

        {{-- EVENTS BREAKDOWN --}}
        <div class="bg-white rounded-xl shadow p-6 border border-gray-100">

            <h2 class="text-xl font-bold text-gray-800 mb-4">Events overzicht</h2>

            @if(empty($eventsPerMonth))
                <p class="text-gray-400 text-sm">Geen data beschikbaar.</p>
            @else
                <div class="space-y-3">

                    @foreach($eventsPerMonth as $month => $count)
                        @php
                            $max = max($eventsPerMonth);
                            $percentage = $max > 0 ? round(($count / $max) * 100) : 0;
                        @endphp

                        <div>
                            <div class="flex justify-between text-sm text-gray-600 mb-1">
                                <span class="font-medium">{{ $month }}</span>
                                <span>{{ $count }} events</span>
                            </div>

                            <div class="w-full bg-gray-100 rounded-full h-3">
                                <div class="bg-indigo-500 h-3 rounded-full transition-all duration-500"
                                     style="width: {{ $percentage }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            @endif

        </div>

    </div>
</x-base-layout>