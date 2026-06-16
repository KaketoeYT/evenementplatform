<x-base-layout>
    <div class="max-w-[1150px] mx-auto px-6 py-12">

        <div class="bg-white border border-slate-100 rounded-[2rem] p-8 md:p-12 shadow-xl shadow-slate-100/50">

            @if (session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl mb-8">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex items-center justify-between mb-10">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">
                        Organizer Request
                    </h1>

                    <p class="text-slate-500 mt-2">
                        Submitted on
                        {{ $request->created_at->format('d-m-Y H:i') }}
                    </p>
                </div>

                <a href="{{ route('organizer_request.overview') }}"
                    class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl transition">
                    Terug
                </a>
            </div>

            <div class="space-y-8">

                <!-- Organisatienaam -->
                <div>
                    <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-2">
                        Organization name
                    </h2>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 text-slate-800">
                        {{ $request->organization_name ?: 'Niet ingevuld' }}
                    </div>
                </div>

                <!-- Event Type -->
                <div>
                    <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-2">
                        Type of events
                    </h2>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 text-slate-800">
                        {{ $request->event_type }}
                    </div>
                </div>

                <!-- Website -->
                <div>
                    <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-2">
                        Website or social media
                    </h2>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                        @if ($request->website)
                            <a href="{{ $request->website }}" target="_blank"
                                class="text-blue-600 hover:underline break-all">
                                {{ $request->website }}
                            </a>
                        @else
                            <span class="text-slate-400">
                                not provided
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
                        Motivation
                    </h2>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 text-slate-800 whitespace-pre-line">
                        {{ $request->motivation }}
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-2">
                        Status
                    </h2>

                    @if ($request->status === 'approved')
                        <div
                            class="inline-flex items-center px-4 py-2 rounded-xl bg-emerald-100 text-emerald-700 font-semibold">
                            granted
                        </div>
                    @elseif($request->status === 'rejected')
                        <div
                            class="inline-flex items-center px-4 py-2 rounded-xl bg-red-100 text-red-700 font-semibold">
                            Rejected
                        </div>
                    @else
                        <div
                            class="inline-flex items-center px-4 py-2 rounded-xl bg-amber-100 text-amber-700 font-semibold">
                            In progress
                        </div>
                    @endif
                </div>

                <!-- Organizer Actie -->
                @if ($request->status === 'pending')
                    <div class="pt-6 border-t border-slate-200 flex flex-wrap gap-4">

                        <!-- Goedkeuren -->
                        <form method="POST" action="{{ route('organizer_request.approve', $request->id) }}">
                            @csrf

                            <button type="submit"
                                class="px-6 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-emerald-200 transition-all">
                                Approve & Create Organizer
                            </button>
                        </form>

                        <!-- Afwijzen -->
                        <form method="POST" action="{{ route('organizer_request.reject', $request->id) }}">
                            @csrf

                            <button type="submit"
                                class="px-6 py-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg shadow-red-200 transition-all">
                                Reject
                            </button>
                        </form>

                    </div>
                @endif

            </div>
        </div>
    </div>
</x-base-layout>
