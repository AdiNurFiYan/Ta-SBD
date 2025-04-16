<!-- resources/views/member/bookings/show.blade.php -->
<x-member-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                🎮 Booking Details
            </h2>
            <a href="{{ route('member.bookings.history') }}" class="mt-2 md:mt-0 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800">
                ⬅️ Back to Bookings
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-6">
                    <!-- Booking Header -->
                    <div class="flex justify-between items-center border-b pb-4 mb-4">
                        <h3 class="text-xl font-semibold text-gray-900">📄 Booking ID: #{{ $booking->id }}</h3>
                        <span class="px-3 py-1 inline-flex text-sm font-bold rounded-full
                            {{ $booking->status === 'pending' ? 'bg-yellow-200 text-yellow-800' : '' }}
                            {{ $booking->status === 'confirmed' ? 'bg-green-200 text-green-800' : '' }}
                            {{ $booking->status === 'completed' ? 'bg-blue-200 text-blue-800' : '' }}
                            {{ $booking->status === 'cancelled' ? 'bg-red-200 text-red-800' : '' }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>

                    <!-- Detail Sections -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">📦 Package Info</h4>
                            <div class="space-y-1 text-gray-800">
                                <p><strong>Name:</strong> {{ $booking->package->name }}</p>
                                <p><strong>Description:</strong> {{ $booking->package->description }}</p>
                                <p><strong>Duration:</strong> {{ $booking->package->duration }} hour(s)</p>
                                <p><strong>Price:</strong> Rp {{ number_format($booking->package->price, 0, ',', '.') }}</p>
                                <p><strong>Facilities:</strong> {{ $booking->package->facilities }}</p>
                                @if($booking->admin && in_array($booking->status, ['confirmed', 'completed', 'cancelled']))
                                    <div class="bg-gray-100 p-2 rounded mt-2">
                                        <strong>Managed by:</strong> {{ $booking->admin->name }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">🕒 Slot Info</h4>
                            <div class="space-y-1 text-gray-800">
                                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($booking->slot->date)->format('D, d M Y') }}</p>
                                <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($booking->slot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->slot->end_time)->format('H:i') }}</p>
                                <p><strong>Booked On:</strong> {{ $booking->created_at->format('d M Y, H:i') }}</p>
                                @if($booking->notes)
                                    <div class="bg-yellow-50 p-2 rounded mt-2">
                                        <strong>Notes:</strong> {{ $booking->notes }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Confirmation / Cancellation Notice -->
                    @if($booking->status === 'confirmed' && $booking->admin)
                        <div class="mt-6 bg-green-50 border-l-4 border-green-400 p-4 rounded">
                            ✅ Confirmed by <strong>{{ $booking->admin->name }}</strong>
                        </div>
                    @endif
                    @if($booking->status === 'cancelled' && $booking->admin)
                        <div class="mt-6 bg-red-50 border-l-4 border-red-400 p-4 rounded">
                            ❌ Cancelled by <strong>{{ $booking->admin->name }}</strong>
                        </div>
                    @endif

                    <!-- Payment Instructions -->
                    @if($booking->status === 'confirmed')
                        <div class="mt-8 bg-blue-50 p-6 rounded-lg border border-blue-200">
                            <h4 class="text-sm font-semibold text-blue-800 mb-2">💰 Payment Instructions</h4>
                            <p class="text-sm text-blue-700">Please transfer the amount below to one of these accounts:</p>
                            <ul class="mt-3 space-y-3">
                                @foreach([['bank' => 'BCA', 'no' => '1234567890'], ['bank' => 'Mandiri', 'no' => '0987654321'], ['bank' => 'BNI', 'no' => '5678901234']] as $account)
                                    <li class="bg-white border rounded p-3 shadow-sm flex justify-between">
                                        <div>
                                            <span class="block font-medium">{{ $account['bank'] }}</span>
                                            <span class="text-sm">{{ $account['no'] }}</span>
                                        </div>
                                        <div class="text-sm font-medium text-right">a/n RePlayy PS</div>
                                    </li>
                                @endforeach
                            </ul>
                            <p class="mt-4 text-blue-700 text-sm">
                                <strong>Total:</strong> Rp {{ number_format($booking->package->price, 0, ',', '.') }}<br>
                                <strong>Include Booking ID:</strong> #{{ $booking->id }} in the transfer description.
                            </p>
                        </div>
                    @endif

                    <!-- Cancel Button -->
                    @if(in_array($booking->status, ['pending', 'confirmed']))
                        <div class="mt-6 text-right">
                            <form method="POST" action="{{ route('member.bookings.cancel', $booking) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" onclick="return confirm('Are you sure you want to cancel this booking?')" class="px-5 py-2 bg-red-600 hover:bg-red-500 text-white text-sm font-semibold rounded-md shadow">
                                    ❌ Cancel Booking
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-member-app-layout>
