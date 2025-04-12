<x-member-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Available Slots') }} - {{ $package->name }}
            </h2>
            <a href="{{ route('member.packages.index') }}" class="mt-2 md:mt-0 inline-flex items-center text-sm text-gray-700 hover:text-gray-900">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Packages
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Package Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $package->name }}</h3>
                    <div class="mt-2">
                        <span class="text-2xl font-bold text-gray-900">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                        <span class="text-gray-500 text-sm">/ {{ $package->duration }} hour(s)</span>
                    </div>
                    
                    <div class="mt-4 text-sm text-gray-600">
                        <p>{{ $package->description }}</p>
                    </div>
                    
                    <div class="mt-4">
                        <h4 class="text-sm font-medium text-gray-900">Facilities:</h4>
                        <p class="text-sm text-gray-600">{{ $package->facilities }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Date Selection -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Select Date</h3>
                    <div class="grid grid-cols-2 md:grid-cols-7 gap-2">
                        @foreach($dates as $d)
                            <a href="{{ route('member.slots.index', ['package' => $package, 'date' => $d['date']]) }}" 
                               class="text-center p-3 rounded-md border {{ $date === $d['date'] ? 'bg-indigo-50 border-indigo-500' : 'border-gray-200 hover:bg-gray-50' }}">
                                <div class="text-xs md:text-sm {{ $date === $d['date'] ? 'text-indigo-700' : 'text-gray-700' }}">
                                    {{ \Carbon\Carbon::parse($d['date'])->format('D') }}
                                </div>
                                <div class="text-sm md:text-base font-medium {{ $date === $d['date'] ? 'text-indigo-700' : 'text-gray-900' }}">
                                    {{ \Carbon\Carbon::parse($d['date'])->format('d') }}
                                </div>
                                <div class="text-xs {{ $date === $d['date'] ? 'text-indigo-700' : 'text-gray-500' }}">
                                    {{ \Carbon\Carbon::parse($d['date'])->format('M') }}
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Time Slots -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Available Time Slots for {{ \Carbon\Carbon::parse($date)->format('D, d M Y') }}</h3>
                    
                    @if($slots->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($slots as $slot)
                                <div class="border rounded-lg overflow-hidden 
                                    {{ $slot->status === 'available' ? 'border-green-200' : 'border-gray-200' }}
                                    {{ $slot->status === 'booked' ? 'border-red-200' : '' }}
                                    {{ $slot->status === 'maintenance' ? 'border-yellow-200' : '' }}">
                                    <div class="p-4 
                                        {{ $slot->status === 'available' ? 'bg-green-50' : 'bg-gray-50' }}
                                        {{ $slot->status === 'booked' ? 'bg-red-50' : '' }}
                                        {{ $slot->status === 'maintenance' ? 'bg-yellow-50' : '' }}">
                                        <div class="font-medium text-center">
                                            {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                                        </div>
                                        <div class="text-xs text-center mt-1
                                            {{ $slot->status === 'available' ? 'text-green-700' : 'text-gray-700' }}
                                            {{ $slot->status === 'booked' ? 'text-red-700' : '' }}
                                            {{ $slot->status === 'maintenance' ? 'text-yellow-700' : '' }}">
                                            {{ ucfirst($slot->status) }}
                                        </div>
                                    </div>
                                    <div class="p-2 text-center">
                                        @if($slot->status === 'available')
                                            <a href="{{ route('member.bookings.create', ['package' => $package, 'slot' => $slot]) }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                                                Book Now
                                            </a>
                                        @else
                                            <span class="text-sm text-gray-400">Not Available</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            No slots available for this date. Please select another date.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-member-app-layout>