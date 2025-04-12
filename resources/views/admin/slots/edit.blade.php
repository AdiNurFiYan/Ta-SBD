<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Slot') }}
            </h2>
            <a href="{{ route('admin.slots.index', ['package_id' => $slot->package_id, 'date' => $slot->date]) }}" class="mt-2 md:mt-0 inline-flex items-center text-sm text-gray-700 hover:text-gray-900">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Slots
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.slots.update', $slot) }}">
                        @csrf
                        @method('PATCH')
                        
                        <!-- Package Info (Read-only) -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Package</label>
                            <div class="mt-1 p-2 bg-gray-50 rounded-md text-gray-900">
                                {{ $slot->package->name }} ({{ $slot->package->duration }} hour(s))
                            </div>
                        </div>
                        
                        <!-- Date & Time Info (Read-only) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date</label>
                                <div class="mt-1 p-2 bg-gray-50 rounded-md text-gray-900">
                                    {{ \Carbon\Carbon::parse($slot->date)->format('D, d M Y') }}
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Time</label>
                                <div class="mt-1 p-2 bg-gray-50 rounded-md text-gray-900">
                                    {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Status -->
                        <div class="mb-6">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="available" {{ old('status', $slot->status) == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="booked" {{ old('status', $slot->status) == 'booked' ? 'selected' : '' }}>Booked</option>
                                <option value="maintenance" {{ old('status', $slot->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex justify-end">
                            <a href="{{ route('admin.slots.index', ['package_id' => $slot->package_id, 'date' => $slot->date]) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 mr-3">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Update Slot
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>