<x-base-layout>
    <x-slot name="title">
        Venues
    </x-slot>

    <div class="container mx-auto max-w-6xl py-10">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Venues</h1>

            <a href="{{ route('venues.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Create Venue
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="p-3">Name</th>
                        <th class="p-3">City</th>
                        <th class="p-3">Country</th>
                        <th class="p-3">Capacity</th>
                        <th class="p-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($venues as $venue)
                        <tr class="border-t">
                            <td class="p-3">{{ $venue->name }}</td>
                            <td class="p-3">{{ $venue->city }}</td>
                            <td class="p-3">{{ $venue->country }}</td>
                            <td class="p-3">{{ $venue->capacity }}</td>

                            <td class="p-3 text-right space-x-2">
                                <a href="{{ route('venues.show', $venue->id) }}"
                                   class="text-blue-600 hover:underline">
                                    View
                                </a>

                                <a href="{{ route('venues.edit', $venue->id) }}"
                                   class="text-yellow-600 hover:underline">
                                    Edit
                                </a>

                                <form action="{{ route('venues.destroy', $venue->id) }}"
                                      method="POST"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="text-red-600 hover:underline"
                                            onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500">
                                No venues found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-base-layout>
