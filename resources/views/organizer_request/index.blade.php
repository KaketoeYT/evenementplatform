<x-base-layout>
    <!-- Formulier Container -->
    <div class="max-w-[1150px] mx-auto px-6 py-12">
        <div class="max-w-2xl bg-white border border-slate-100 rounded-[2rem] p-8 md:p-12 shadow-xl shadow-slate-100/50">

            @if (session('success'))
                <div
                    class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl mb-8 flex items-center gap-3">
                    <span class="text-emerald-500 text-xl">✓</span>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('organizer_request.store') }}" class="space-y-8">
                @csrf

                <!-- Organisatienaam -->
                <div>
                    <label class="block text-sm font-bold text-slate-900 uppercase tracking-wider mb-2">
                        Organisatienaam
                    </label>
                    <input type="text" name="organization_name" value="{{ old('organization_name') }}"
                        class="w-full border border-slate-200 rounded-xl p-4 text-slate-950 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all"
                        placeholder="Bijv. Haarlem Events">
                </div>

                <!-- Type Evenementen -->
                <div>
                    <label class="block text-sm font-bold text-slate-900 uppercase tracking-wider mb-2">
                        Wat voor evenementen organiseer je?
                    </label>
                    <input type="text" name="event_type" value="{{ old('event_type') }}"
                        class="w-full border border-slate-200 rounded-xl p-4 text-slate-950 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all"
                        placeholder="Bijv. techno, business, food festivals" required>
                </div>

                <!-- Website / Socials -->
                <div>
                    <label class="block text-sm font-bold text-slate-900 uppercase tracking-wider mb-2">
                        Website of social media
                    </label>
                    <input type="url" name="website" value="{{ old('website') }}"
                        class="w-full border border-slate-200 rounded-xl p-4 text-slate-950 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all"
                        placeholder="https://">
                </div>

                <!-- Ervaring -->
                <div>
                    <label class="block text-sm font-bold text-slate-900 uppercase tracking-wider mb-2">
                        Ervaring
                    </label>
                    <textarea name="experience" rows="4"
                        class="w-full border border-slate-200 rounded-xl p-4 text-slate-950 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all resize-none"
                        placeholder="Vertel kort iets over je ervaring.">{{ old('experience') }}</textarea>
                </div>

                <!-- Motivatie -->
                <div>
                    <label class="block text-sm font-bold text-slate-900 uppercase tracking-wider mb-2">
                        Motivatie
                    </label>
                    <textarea name="motivation" rows="5"
                        class="w-full border border-slate-200 rounded-xl p-4 text-slate-950 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all resize-none"
                        placeholder="Waarom wil je evenementen publiceren op het platform?" required>{{ old('motivation') }}</textarea>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full sm:w-auto px-8 py-4 bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-xl hover:shadow-blue-300 transition-all text-center block">
                        Aanvraag versturen
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-base-layout>

