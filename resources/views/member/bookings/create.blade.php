<x-member-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Confirm Booking') }}
            </h2>
            <a href="{{ route('member.slots.index', $package) }}" class="mt-2 md:mt-0 inline-flex items-center text-sm text-gray-700 hover:text-gray-900">
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
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Booking Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Package</h4>
                            <div class="text-gray-900">
                                <h5 class="text-base font-semibold">{{ $package->name }}</h5>
                                <p class="text-sm mt-1">{{ $package->description }}</p>
                                <p class="text-sm mt-1"><strong>Duration:</strong> {{ $package->duration }} hour(s)</p>
                                <p class="text-sm mt-1"><strong>Price:</strong> Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                                <p class="text-sm mt-1"><strong>Facilities:</strong> {{ $package->facilities }}</p>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Slot Details</h4>
                            <div class="text-gray-900">
                                <p class="text-sm"><strong>Date:</strong> {{ \Carbon\Carbon::parse($slot->date)->format('D, d M Y') }}</p>
                                <p class="text-sm mt-1"><strong>Time:</strong> {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('member.bookings.store', ['package' => $package, 'slot' => $slot]) }}">
                        @csrf
                        
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Additional Notes (Optional)</label>
                            <textarea id="notes" name="notes" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Any special requests or notes for your booking...">{{ old('notes') }}</textarea>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-md mb-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm text-yellow-800 font-medium">Booking Information</h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>By confirming this booking, you agree to the following:</p>
                                        <ul class="list-disc pl-5 mt-1 space-y-1">
                                            <li>Payment must be completed upon confirmation.</li>
                                            <li>Cancellation is allowed up to 24 hours before the booking time.</li>
                                            <li>Please arrive 15 minutes before your slot time.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <a href="{{ route('member.slots.index', $package) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 mr-3">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Confirm Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-member-app-layout>