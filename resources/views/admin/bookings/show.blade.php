<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Booking Details') }}
            </h2>
            <a href="{{ route('admin.bookings.index') }}" class="mt-2 md:mt-0 inline-flex items-center text-sm text-gray-700 hover:text-gray-900">
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
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Member Details</h4>
                            <div class="bg-gray-50 p-4 rounded-md">
                                <div class="flex items-center mb-2">
                                    <svg class="h-5 w-5 text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <h5 class="text-gray-900 font-medium">{{ $booking->member->name }}</h5>
                                </div>
                                <p class="text-sm text-gray-600 ml-7 mb-2">{{ $booking->member->email }}</p>
                                <p class="text-sm text-gray-600 ml-7">Member since: {{ $booking->member->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Package Details</h4>
                            <div class="bg-gray-50 p-4 rounded-md">
                                <h5 class="text-base font-semibold text-gray-900">{{ $booking->package->name }}</h5>
                                <p class="text-sm mt-1 text-gray-600">{{ $booking->package->description }}</p>
                                <p class="text-sm mt-1 text-gray-600"><strong>Duration:</strong> {{ $booking->package->duration }} hour(s)</p>
                                <p class="text-sm mt-1 text-gray-600"><strong>Price:</strong> Rp {{ number_format($booking->package->price, 0, ',', '.') }}</p>
                                <p class="text-sm mt-1 text-gray-600"><strong>Facilities:</strong> {{ $booking->package->facilities }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Slot Details</h4>
                        <div class="bg-gray-50 p-4 rounded-md">
                            <div class="flex items-center mb-2">
                                <svg class="h-5 w-5 text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <h5 class="text-gray-900 font-medium">{{ \Carbon\Carbon::parse($booking->slot->date)->format('D, d M Y') }}</h5>
                            </div>
                            <p class="text-sm text-gray-600 ml-7 mb-2">
                                <strong>Time:</strong> {{ \Carbon\Carbon::parse($booking->slot->start_time)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($booking->slot->end_time)->format('H:i') }}
                            </p>
                            <p class="text-sm text-gray-600 ml-7">
                                <strong>Current Slot Status:</strong> 
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $booking->slot->status === 'available' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $booking->slot->status === 'booked' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $booking->slot->status === 'maintenance' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                    {{ ucfirst($booking->slot->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Booking Information</h4>
                        <div class="bg-gray-50 p-4 rounded-md">
                            <p class="text-sm text-gray-600"><strong>Booking Date:</strong> {{ $booking->created_at->format('d M Y, H:i') }}</p>
                            
                            @if($booking->notes)
                                <div class="mt-4">
                                    <h5 class="text-sm font-medium text-gray-700">Additional Notes:</h5>
                                    <p class="text-sm mt-1 text-gray-600">{{ $booking->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-8">
                        <div class="flex flex-wrap gap-3 justify-end">
                            @if($booking->status === 'pending')
                                <form method="POST" action="{{ route('admin.bookings.confirm', $booking) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                        Confirm Booking
                                    </button>
                                </form>
                            @endif
                            
                            @if($booking->status === 'confirmed')
                                <form method="POST" action="{{ route('admin.bookings.complete', $booking) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Mark as Completed
                                    </button>
                                </form>
                            @endif
                            
                            @if(in_array($booking->status, ['pending', 'confirmed']))
                                <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                        Cancel Booking
                                    </button>
                                </form>
                            @endif
                            
                            <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2" onclick="return confirm('Are you sure you want to remove this booking?')">
                                    Remove Booking
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>