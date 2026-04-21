<x-base-layout>
    <x-slot name="title">
        Venue Details
    </x-slot>

    <div class="container mx-auto max-w-3xl py-10">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">{{ $venue->name }}</h1>

            <div class="flex gap-2">
                <a href="{{ route('venues.edit', $venue->id) }}"
                   class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                    Edit
                </a>

                <a href="{{ route('venues.index') }}"
                   class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
                    Back
                </a>
            </div>
        </div>

        <div class="bg-white shadow rounded p-6 space-y-4">

            <div>
                <span class="font-semibold">City:</span>
                <span>{{ $venue->city }}</span>
            </div>

            <div>
                <span class="font-semibold">Country:</span>
                <span>{{ $venue->country }}</span>
            </div>

            <div>
                <span class="font-semibold">Street:</span>
                <span>{{ $venue->street }}</span>
            </div>

            <div>
                <span class="font-semibold">Zipcode:</span>
                <span>{{ $venue->zipcode }}</span>
            </div>

            <div>
                <span class="font-semibold">Capacity:</span>
                <span>{{ $venue->capacity }}</span>
            </div>

        </div>

        {{-- Delete section --}}
        <div class="mt-6">
            <form action="{{ route('venues.destroy', $venue->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <button type="submit"
                        onclick="return confirm('Are you sure you want to delete this venue?')"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Delete Venue
                </button>
            </form>
        </div>

    </div>
</x-base-layout>
