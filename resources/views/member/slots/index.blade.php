<x-member-app-layout>
    <x-slot name="header">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-2 md:space-y-0">
            <h2 class="font-bold text-2xl text-[#0118D8] leading-tight">
                {{ __('Available Slots') }} - {{ $package->name }}
            </h2>
            <a href="{{ route('member.packages.index') }}" class="mt-2 md:mt-0 inline-flex items-center text-sm text-[#0118D8] hover:underline">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Packages
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#FFF8F8] min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            
            <!-- Package Details -->
            <div class="bg-white shadow-md border-2 border-[#E9DFC3] rounded-xl p-6 space-y-4">
                <h3 class="text-xl font-bold text-[#0118D8]">{{ $package->name }}</h3>
                <div class="mt-2 flex items-center">
                    <span class="text-3xl font-bold text-gray-900">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                    <span class="text-gray-600 text-lg ml-2">/ {{ $package->duration }} hour(s)</span>
                </div>
                <p class="mt-4 text-base text-gray-700">{{ $package->description }}</p>
                <div class="mt-4 bg-[#FFF8F8] p-4 rounded-lg">
                    <h4 class="text-base font-semibold text-gray-800 flex items-center">
                        <svg class="h-5 w-5 mr-2 text-[#1B56FD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Facilities:
                    </h4>
                    <p class="text-base text-gray-700 mt-1">{{ $package->facilities }}</p>
                </div>
            </div>

            <!-- Date Selector -->
            <div class="bg-white shadow-lg border-2 border-[#E9DFC3] sm:rounded-xl p-6">
                <h3 class="text-lg font-bold text-[#0118D8] mb-4">Select Date</h3>
                <div class="overflow-x-auto">
                    <div class="grid grid-cols-2 md:grid-cols-7 gap-3 w-max md:w-auto">
                        @foreach($dates as $d)
                            <a href="{{ route('member.slots.index', ['package' => $package, 'date' => $d['date']]) }}" 
                               class="text-center p-3 rounded-lg font-medium border transition duration-200 
                               {{ $date === $d['date'] ? 'bg-[#0118D8] text-white border-[#0118D8]' : 'bg-white border-gray-300 hover:bg-gray-100 text-gray-800' }}">
                                <div>{{ \Carbon\Carbon::parse($d['date'])->format('D') }}</div>
                                <div class="text-lg">{{ \Carbon\Carbon::parse($d['date'])->format('d') }}</div>
                                <div class="text-sm">{{ \Carbon\Carbon::parse($d['date'])->format('M') }}</div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Slot List -->
            <div class="bg-white shadow-lg border-2 border-[#E9DFC3] sm:rounded-xl p-6">
                <h3 class="text-lg font-bold text-[#0118D8] mb-4">Available Time Slots for {{ \Carbon\Carbon::parse($date)->format('D, d M Y') }}</h3>

                @if($slots->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($slots as $slot)
                            <div class="rounded-xl border-2 p-4 flex flex-col justify-between
                                {{ $slot->status === 'available' ? 'border-green-300 bg-green-50' : '' }}
                                {{ $slot->status === 'booked' ? 'border-red-300 bg-red-50' : '' }}
                                {{ $slot->status === 'maintenance' ? 'border-yellow-300 bg-yellow-50' : '' }}">
                                <div class="text-center font-semibold text-lg text-gray-900">
                                    {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                                </div>
                                <div class="text-center text-sm mt-1
                                    {{ $slot->status === 'available' ? 'text-green-700' : '' }}
                                    {{ $slot->status === 'booked' ? 'text-red-700' : '' }}
                                    {{ $slot->status === 'maintenance' ? 'text-yellow-700' : '' }}">
                                    {{ ucfirst($slot->status) }}
                                </div>
                                <div class="mt-4 text-center">
                                    @if($slot->status === 'available')
                                        <a href="{{ route('member.bookings.create', ['package' => $package, 'slot' => $slot]) }}"
                                           class="inline-block px-4 py-2 bg-[#0118D8] text-white text-sm font-bold rounded-lg shadow hover:bg-[#1B56FD] transition">
                                            Book Now
                                        </a>
                                    @else
                                        <span class="text-sm text-gray-500">Not Available</span>
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
</x-member-app-layout>
