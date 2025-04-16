<x-member-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-2 md:space-y-0">
            <h2 class="font-bold text-2xl text-[#0118D8] leading-tight">
                {{ __('Confirm Booking') }}
            </h2>
            <a href="{{ route('member.slots.index', $package) }}" class="inline-flex items-center text-sm text-[#0118D8] hover:underline">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Slots
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#FFF8F8] min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Booking Details -->
            <div class="bg-white border-2 border-[#E9DFC3] rounded-xl shadow-sm p-6 space-y-6">
                <h3 class="text-xl font-bold text-[#0118D8]">Booking Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Package</h4>
                        <div class="text-gray-900 space-y-1">
                            <p class="font-semibold">{{ $package->name }}</p>
                            <p class="text-sm">{{ $package->description }}</p>
                            <p class="text-sm"><strong>Duration:</strong> {{ $package->duration }} hour(s)</p>
                            <p class="text-sm"><strong>Price:</strong> Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                            <p class="text-sm"><strong>Facilities:</strong> {{ $package->facilities }}</p>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Slot Details</h4>
                        <div class="text-gray-900 space-y-1">
                            <p class="text-sm"><strong>Date:</strong> {{ \Carbon\Carbon::parse($slot->date)->format('D, d M Y') }}</p>
                            <p class="text-sm"><strong>Time:</strong> {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('member.bookings.store', ['package' => $package, 'slot' => $slot]) }}">
                @csrf

                <div class="bg-white border-2 border-[#E9DFC3] rounded-xl shadow-sm p-6 space-y-6">

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">Additional Notes (Optional)</label>
                        <textarea id="notes" name="notes" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0118D8] focus:ring-[#0118D8]" placeholder="Any special requests or notes for your booking...">{{ old('notes') }}</textarea>
                    </div>

                    <!-- Booking Info -->
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-yellow-500 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h3 class="text-sm font-bold text-yellow-800">Booking Information</h3>
                                <ul class="list-disc pl-5 mt-2 text-sm text-yellow-700 space-y-1">
                                    <li>Payment must be completed upon confirmation.</li>
                                    <li>Cancellation is allowed up to 24 hours before the booking time.</li>
                                    <li>Please arrive 15 minutes before your slot time.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('member.slots.index', $package) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-700 font-medium hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#0118D8] text-white text-sm font-bold rounded-md shadow hover:bg-[#1B56FD] transition">
                            Confirm Booking
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-member-app-layout>
