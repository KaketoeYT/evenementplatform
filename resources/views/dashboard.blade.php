
<x-layouts.app>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Mijn Dashboard') }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Welkom terug, {{ auth()->user()->name }}. Hier is je actuele status.</p>
    </div>

    <!-- STATS GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- TICKET STATUS CARD -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Mijn Tickets') }}</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-1">
                    {{ count($tickets ?? []) }}
                    </p>
                    <p class="text-xs text-green-500 flex items-center mt-1">
                        {{ __('Actieve reserveringen') }}
                    </p>
                </div>
                <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-xl">
                    <svg class="h-6 w-6 text-blue-500 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- WACHTRIJ STATUS CARD -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Actieve Wachtrijen') }}</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-1">{{ count($queues) }}</p>
                    <p class="text-xs text-orange-500 flex items-center mt-1 font-semibold italic">
                        {{ count($queues) > 0 ? __('Je staat op de lijst') : __('Geen actieve wachtrijen') }}
                    </p>
                </div>
                <div class="bg-orange-100 dark:bg-orange-900 p-3 rounded-xl">
                    <svg class="h-6 w-6 text-orange-500 dark:text-orange-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- MIJN TICKETS LIJST -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                <h3 class="font-bold text-gray-800 dark:text-gray-100">{{ __('Mijn Aankomende Evenementen') }}</h3>
                <a href="#" class="text-blue-500 text-xs font-bold uppercase hover:underline">{{ __('Bekijk alles') }}</a>
            </div>
            <div class="p-5">
                <div class="space-y-4">
                    @forelse($tickets as $ticket)
                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-100 dark:border-gray-600">
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 dark:text-white">{{ $ticket->event->name }}</h4>
                                <div class="flex items-center text-xs text-gray-500 mt-1">
                                    <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    {{ \Carbon\Carbon::parse($ticket->event->datetime)->format('d-m-Y H:i') }}
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 text-[10px] font-bold px-2 py-1 rounded uppercase">
                                    #{{ $ticket->ticket_number }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-4 italic">{{ __('Je hebt nog geen tickets.') }}</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- WACHTRIJ DETAIL LIJST -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-5 border-b border-gray-100 dark:border-gray-700">
                <h3 class="font-bold text-gray-800 dark:text-gray-100">{{ __('Wachtrij Posities') }}</h3>
            </div>
            <div class="p-5">
                <div class="space-y-4">
                    @forelse($queues as $queue)
                        <div class="relative p-4 rounded-xl border {{ $queue->invited_at ? 'bg-orange-50 border-orange-200 dark:bg-orange-900/20' : 'bg-gray-50 border-gray-100 dark:bg-gray-700/50' }}">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-white text-sm">{{ $queue->event->name }}</h4>
                                    <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-wider italic">In de rij sinds {{ $queue->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="text-center bg-white dark:bg-gray-800 h-12 w-12 rounded-lg shadow-sm border border-gray-100 dark:border-gray-600 flex flex-col justify-center">
                                    <span class="text-[9px] text-gray-400 font-bold leading-none uppercase">Nr</span>
                                    <span class="text-lg font-black text-blue-600 leading-tight">#{{ $queue->position }}</span>
                                </div>
                            </div>

                            @if($queue->invited_at)
                                <div class="mt-3 flex items-center justify-center p-2 bg-white dark:bg-gray-800 rounded-lg shadow-inner border border-orange-200 animate-pulse">
                                    <span class="text-[10px] text-orange-600 font-black uppercase">{{ __('Nu beschikbaar! Check je e-mail.') }}</span>
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-4 italic">{{ __('Je staat momenteel niet in een wachtrij.') }}</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</x-layouts.app>