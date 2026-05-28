<x-base-layout>
    <div class="max-w-[1150px] mx-auto px-6 py-12">

        <div class="bg-white border border-slate-100 rounded-[2rem] p-8 md:p-12 shadow-xl shadow-slate-100/50">

            <div class="flex items-center justify-between mb-10">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">
                        Organisator Aanvraag
                    </h1>

                    <p class="text-slate-500 mt-2">
                        Ingestuurd op
                        {{ $request->created_at->format('d-m-Y H:i') }}
                    </p>
                </div>

                <a href="{{ redirect()->back()->getTargetUrl() }}"
                    class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl transition">
                    Terug
                </a>
            </div>

            <div class="space-y-8">

                <!-- Organisatienaam -->
                <div>
                    <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-2">
                        Organisatienaam
                    </h2>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 text-slate-800">
                        {{ $request->organization_name ?: 'Niet ingevuld' }}
                    </div>
                </div>

                <!-- Event Type -->
                <div>
                    <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-2">
                        Type evenementen
                    </h2>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 text-slate-800">
                        {{ $request->event_type }}
                    </div>
                </div>

                <!-- Website -->
                <div>
                    <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-2">
                        Website / Social Media
                    </h2>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                        @if ($request->website)
                            <a href="{{ $request->website }}" target="_blank"
                                class="text-blue-600 hover:underline break-all">
                                {{ $request->website }}
                            </a>
                        @else
                            <span class="text-slate-400">
                                Niet ingevuld
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Ervaring -->
                <div>
                    <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-2">
                        Ervaring
                    </h2>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 text-slate-800 whitespace-pre-line">
                        {{ $request->experience ?: 'Niet ingevuld' }}
                    </div>
                </div>

                <!-- Motivatie -->
                <div>
                    <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-2">
                        Motivatie
                    </h2>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 text-slate-800 whitespace-pre-line">
                        {{ $request->motivation }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-base-layout>
