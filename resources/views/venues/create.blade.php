<x-base-layout>
    <x-slot name="title">
        Create Venue
    </x-slot>

    <div class="container mx-auto max-w-2xl py-10">
        <h1 class="text-3xl font-bold mb-6">Create New Venue</h1>

        <form action="{{ route('venues.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block font-medium">Name</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    required 
                    class="w-full border rounded p-2"
                >
            </div>

            <div>
                <label for="city" class="block font-medium">City</label>
                <input 
                    type="text" 
                    name="city" 
                    id="city" 
                    required 
                    class="w-full border rounded p-2"
                >
            </div>

            <div>
                <label for="country" class="block font-medium">Country</label>
                <input 
                    type="text" 
                    name="country" 
                    id="country" 
                    required 
                    class="w-full border rounded p-2"
                >
            </div>

            <div>
                <label for="street" class="block font-medium">Street</label>
                <textarea 
                    name="street" 
                    id="street" 
                    rows="3"
                    class="w-full border rounded p-2"
                ></textarea>
            </div>

            <div>
                <label for="zipcode" class="block font-medium">Zipcode</label>
                <input 
                    type="text" 
                    name="zipcode" 
                    id="zipcode" 
                    required 
                    class="w-full border rounded p-2"
                >
            </div>

            <div>
                <label for="capacity" class="block font-medium">Capacity</label>
                <input 
                    type="number" 
                    name="capacity" 
                    id="capacity" 
                    required 
                    class="w-full border rounded p-2"
                >
            </div>

            <div class="pt-4">
                <button 
                    type="submit" 
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                >
                    Create Venue
                </button>
            </div>
        </form>
    </div>
</x-base-layout>
