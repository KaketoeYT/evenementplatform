<x-base-layout>
    <div class="max-w-[1400px] mx-auto px-6 py-12">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-10">
            <div>
                <h1 class="text-4xl font-black text-slate-950 tracking-tight">
                  new event request
                </h1>

                <p class="text-slate-500 mt-2 text-lg">
                    fill in the form for a new event request 
                </p>
            </div>

            <a href="{{ route('eventrequests.index') }}"
                class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">
                Back to Overview
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 p-5 rounded-2xl mb-8">
                <p class="font-semibold mb-2">There are a few issues with your input:</p>
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white border border-slate-100 rounded-[2rem] overflow-hidden shadow-xl shadow-slate-100/50 p-8">
            <form method="POST" action="{{ route('eventrequests.store') }}" class="space-y-8">
                @csrf

                <div class="grid gap-6 md:grid-cols-2">
                    <div class="space-y-3">
                        <label for="name" class="block text-sm font-semibold text-slate-700">Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200"
                            placeholder="Name of the request">
                        @error('name')
                            <p class="text-rose-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-3">
                        <label for="venue_id" class="block text-sm font-semibold text-slate-700">Location</label>
                        <select id="venue_id" name="venue_id"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200">
                            <option value="">Select a location</option>
                            @foreach ($venues as $venue)
                                <option value="{{ $venue->id }}"
                                    {{ old('venue_id') == $venue->id ? 'selected' : '' }}>{{ $venue->name }}</option>
                            @endforeach
                        </select>
                        @error('venue_id')
                            <p class="text-rose-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-3">
                    <label for="description" class="block text-sm font-semibold text-slate-700">Description</label>
                    <textarea id="description" name="description" rows="6"
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200"
                        placeholder="Describe the event request">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-rose-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                <div class="text-sm text-slate-500">
                    Request will be created for the logged-in user: {{ auth()->user()?->name ?? 'Unknown' }}
                </div>
                @error('user_id')
                    <p class="text-rose-600 text-sm mt-1">{{ $message }}</p>
                @enderror

                <div
                    class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-slate-100">
                    <a href="{{ route('eventrequests.index') }}"
                        class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">
                        cancel
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-full bg-slate-950 px-8 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                        create request
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-base-layout>
