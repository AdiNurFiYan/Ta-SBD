<x-member-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Booking History</h3>

                    {{-- Success message --}}
                    @if(session('success'))
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Error message --}}
                    @if(session('error'))
                        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Booking table --}}
                    @if($bookings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-indigo-50 text-gray-700 text-left uppercase text-xs tracking-wider">
                                    <tr>
                                        <th class="px-6 py-3">Booking ID</th>
                                        <th class="px-6 py-3">Package</th>
                                        <th class="px-6 py-3">Date & Time</th>
                                        <th class="px-6 py-3">Status</th>
                                        <th class="px-6 py-3">Booked On</th>
                                        <th class="px-6 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($bookings as $booking)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 font-bold text-indigo-700">#{{ $booking->id }}</td>
                                            <td class="px-6 py-4 text-gray-800">{{ $booking->package->name }}</td>
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ \Carbon\Carbon::parse($booking->slot->date)->format('d M Y') }},
                                                {{ \Carbon\Carbon::parse($booking->slot->start_time)->format('H:i') }} -
                                                {{ \Carbon\Carbon::parse($booking->slot->end_time)->format('H:i') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold
                                                    {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $booking->status === 'completed' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                                    @if($booking->status === 'pending')
                                                        ⏳
                                                    @elseif($booking->status === 'confirmed')
                                                        ✅
                                                    @elseif($booking->status === 'completed')
                                                        🏁
                                                    @elseif($booking->status === 'cancelled')
                                                        ❌
                                                    @endif
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">{{ $booking->created_at->format('d M Y, H:i') }}</td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-2">
                                                    <a href="{{ route('member.bookings.show', $booking) }}"
                                                       class="inline-block px-3 py-1 text-xs font-medium text-white bg-blue-500 rounded hover:bg-blue-600">
                                                        View
                                                    </a>
                                                    @if(in_array($booking->status, ['pending', 'confirmed']))
                                                        <form method="POST" action="{{ route('member.bookings.cancel', $booking) }}">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit"
                                                                    onclick="return confirm('Are you sure you want to cancel this booking?')"
                                                                    class="inline-block px-3 py-1 text-xs font-medium text-white bg-red-500 rounded hover:bg-red-600">
                                                                Cancel
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $bookings->links() }}
                        </div>
                    @else
                        <div class="text-center py-12 text-gray-500">
                            <p class="text-lg">You don't have any bookings yet.</p>
                            <div class="mt-4">
                                <a href="{{ route('member.packages.index') }}" class="inline-block px-4 py-2 text-white bg-indigo-600 rounded hover:bg-indigo-700 text-sm font-medium">
                                    Browse Packages
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-member-app-layout>
