<x-base-layout>
    <x-slot name="title">
        Edit Venue
    </x-slot>

    <div class="container mx-auto max-w-2xl py-10">

        <h1 class="text-3xl font-bold mb-6">Edit Venue</h1>

        {{-- Errors --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('venues.update', $venue->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block font-medium">Name</label>
                <input type="text" name="name" id="name"
                       value="{{ old('name', $venue->name) }}"
                       class="w-full border p-2 rounded"
                       required>
            </div>

            <div>
                <label for="city" class="block font-medium">City</label>
                <input type="text" name="city" id="city"
                       value="{{ old('city', $venue->city) }}"
                       class="w-full border p-2 rounded"
                       required>
            </div>

            <div>
                <label for="country" class="block font-medium">Country</label>
                <input type="text" name="country" id="country"
                       value="{{ old('country', $venue->country) }}"
                       class="w-full border p-2 rounded"
                       required>
            </div>

            <div>
                <label for="street" class="block font-medium">Street</label>
                <textarea name="street" id="street"
                          class="w-full border p-2 rounded"
                          required>{{ old('street', $venue->street) }}</textarea>
            </div>

            <div>
                <label for="zipcode" class="block font-medium">Zipcode</label>
                <input type="text" name="zipcode" id="zipcode"
                       value="{{ old('zipcode', $venue->zipcode) }}"
                       class="w-full border p-2 rounded"
                       required>
            </div>

            <div>
                <label for="capacity" class="block font-medium">Capacity</label>
                <input type="number" name="capacity" id="capacity"
                       value="{{ old('capacity', $venue->capacity) }}"
                       class="w-full border p-2 rounded"
                       required>
            </div>

            <div class="pt-4 flex gap-3">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Update Venue
                </button>

                <a href="{{ route('venues.index') }}"
                   class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</x-base-layout>
