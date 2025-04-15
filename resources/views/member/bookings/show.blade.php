<!-- resources/views/member/bookings/show.blade.php -->
<x-member-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Booking Details') }}
            </h2>
            <a href="{{ route('member.bookings.history') }}" class="mt-2 md:mt-0 inline-flex items-center text-sm text-gray-700 hover:text-gray-900">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Bookings
            </a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <h3 class="text-lg font-semibold text-gray-900">Booking #{{ $booking->id }}</h3>
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                        {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $booking->status === 'completed' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Package Details</h4>
                            <div class="text-gray-900">
                                <h5 class="text-base font-semibold">{{ $booking->package->name }}</h5>
                                <p class="text-sm mt-1">{{ $booking->package->description }}</p>
                                <p class="text-sm mt-1"><strong>Duration:</strong> {{ $booking->package->duration }} hour(s)</p>
                                <p class="text-sm mt-1"><strong>Price:</strong> Rp {{ number_format($booking->package->price, 0, ',', '.') }}</p>
                                <p class="text-sm mt-1"><strong>Facilities:</strong> {{ $booking->package->facilities }}</p>
                                
                                <!-- Menambahkan informasi admin yang mengelola booking -->
                                @if($booking->admin && in_array($booking->status, ['confirmed', 'completed', 'cancelled']))
                                    <p class="text-sm mt-3 p-2 bg-gray-50 rounded">
                                        <strong>Managed by:</strong> {{ $booking->admin->name }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Slot Details</h4>
                            <div class="text-gray-900">
                                <p class="text-sm"><strong>Date:</strong> {{ \Carbon\Carbon::parse($booking->slot->date)->format('D, d M Y') }}</p>
                                <p class="text-sm mt-1"><strong>Time:</strong> {{ \Carbon\Carbon::parse($booking->slot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->slot->end_time)->format('H:i') }}</p>
                                <p class="text-sm mt-1"><strong>Booked On:</strong> {{ $booking->created_at->format('d M Y, H:i') }}</p>
                                
                                @if($booking->notes)
                                <div class="mt-4">
                                    <h5 class="text-sm font-medium">Additional Notes:</h5>
                                    <p class="text-sm mt-1">{{ $booking->notes }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Menampilkan nama admin yang mengonfirmasi booking -->
                    @if($booking->status === 'confirmed' && $booking->admin)
                    <div class="mt-4 p-4 bg-green-50 rounded-lg border border-green-200">
                        <h4 class="text-sm font-medium text-green-800 mb-2">Confirmed By</h4>
                        <p class="text-sm text-green-700">This booking was confirmed by <strong>{{ $booking->admin->name }}</strong></p>
                    </div>
                    @endif
                    
                    <!-- Menampilkan nama admin yang membatalkan booking -->
                    @if($booking->status === 'cancelled' && $booking->admin)
                    <div class="mt-4 p-4 bg-red-50 rounded-lg border border-red-200">
                        <h4 class="text-sm font-medium text-red-800 mb-2">Cancelled By</h4>
                        <p class="text-sm text-red-700">This booking was cancelled by <strong>{{ $booking->admin->name }}</strong></p>
                    </div>
                    @endif
                    
                    @if($booking->status === 'confirmed')
                    <div class="mt-8 p-4 bg-green-50 rounded-lg border border-green-200">
                        <h4 class="text-sm font-semibold text-green-800 mb-2">Payment Information</h4>
                        <p class="text-sm text-green-700">Please complete your payment by transferring to one of these accounts:</p>
                        <div class="mt-2 space-y-2">
                            <div class="flex flex-col sm:flex-row sm:justify-between p-3 bg-white rounded border border-green-200">
                                <div>
                                    <span class="text-sm font-medium">BCA</span>
                                    <p class="text-sm">1234567890</p>
                                </div>
                                <div class="mt-2 sm:mt-0">
                                    <span class="text-sm font-medium">a/n RePlayy PS</span>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between p-3 bg-white rounded border border-green-200">
                                <div>
                                    <span class="text-sm font-medium">Mandiri</span>
                                    <p class="text-sm">0987654321</p>
                                </div>
                                <div class="mt-2 sm:mt-0">
                                    <span class="text-sm font-medium">a/n RePlayy PS</span>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between p-3 bg-white rounded border border-green-200">
                                <div>
                                    <span class="text-sm font-medium">BNI</span>
                                    <p class="text-sm">5678901234</p>
                                </div>
                                <div class="mt-2 sm:mt-0">
                                    <span class="text-sm font-medium">a/n RePlayy PS</span>
                                </div>
                            </div>
                        </div>
                        <p class="mt-4 text-sm text-green-700">
                            Amount to transfer: <span class="font-bold">Rp {{ number_format($booking->package->price, 0, ',', '.') }}</span>
                        </p>
                        <p class="mt-2 text-sm text-green-700">
                            Please include your booking ID <span class="font-bold">#{{ $booking->id }}</span> in the transfer description.
                        </p>
                    </div>
                    @endif
                    
                    <div class="mt-8 flex justify-end">
                        @if(in_array($booking->status, ['pending', 'confirmed']))
                        <form method="POST" action="{{ route('member.bookings.cancel', $booking) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                Cancel Booking
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-member-app-layout>