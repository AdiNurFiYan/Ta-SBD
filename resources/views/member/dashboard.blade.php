<x-member-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-[#0118D8]">
            🎮 Welcome to Your GameZone, {{ $member->name }}!
        </h2>
    </x-slot>

    <div class="py-12 bg-[#E9DFC3] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            <!-- Welcome Section -->
            <div class="bg-[#FFF8F8] shadow-lg rounded-2xl p-8">
                <h3 class="text-2xl font-bold text-[#1B56FD] mb-2">Hey {{ $member->name }} 👋</h3>
                <p class="text-gray-700 text-lg mb-6">Time to level up! Choose a package or manage your sessions easily below.</p>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('member.packages.index') }}"
                       class="bg-[#1B56FD] hover:bg-[#0118D8] text-white px-6 py-3 rounded-xl font-semibold shadow-md transition duration-300 ease-in-out">
                        🎁 Browse Packages
                    </a>

                    <a href="{{ route('member.bookings.history') }}"
                       class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-semibold shadow-md transition duration-300 ease-in-out">
                        📅 My Bookings
                    </a>
                </div>
            </div>

            <!-- Bookings Section -->
            <div class="bg-[#FFF8F8] shadow-lg rounded-2xl p-8">
                <h3 class="text-xl font-bold text-[#0118D8] mb-6">📌 Your Recent Bookings</h3>

                @if($pendingBookings->count() > 0)
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full text-sm text-left text-gray-600">
                            <thead class="bg-[#E9DFC3] text-gray-800 text-xs uppercase">
                                <tr>
                                    <th class="px-6 py-3">Package</th>
                                    <th class="px-6 py-3">Date & Time</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pendingBookings as $booking)
                                    <tr>
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $booking->package->name }}</td>
                                        <td class="px-6 py-4">
                                            {{ \Carbon\Carbon::parse($booking->slot->date)->format('d M Y') }},
                                            {{ \Carbon\Carbon::parse($booking->slot->start_time)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($booking->slot->end_time)->format('H:i') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full 
                                                {{ $booking->status === 'pending' ? 'bg-yellow-200 text-yellow-900' : '' }}
                                                {{ $booking->status === 'confirmed' ? 'bg-green-200 text-green-900' : '' }}
                                                {{ $booking->status === 'completed' ? 'bg-blue-200 text-blue-900' : '' }}
                                                {{ $booking->status === 'cancelled' ? 'bg-red-200 text-red-900' : '' }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 space-x-4">
                                            <a href="{{ route('member.bookings.show', $booking) }}"
                                               class="text-[#1B56FD] hover:underline">View</a>

                                            @if(in_array($booking->status, ['pending', 'confirmed']))
                                                <form method="POST" action="{{ route('member.bookings.cancel', $booking) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                            class="text-red-600 hover:underline"
                                                            onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                        Cancel
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-base">🚫 You don’t have any active bookings right now.</p>
                @endif

                <div class="mt-6">
                    <a href="{{ route('member.bookings.history') }}"
                       class="text-[#0118D8] hover:underline font-medium text-sm">→ View all bookings</a>
                </div>
            </div>
        </div>
    </div>
</x-member-app-layout>
