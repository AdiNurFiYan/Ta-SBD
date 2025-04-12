<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Member Details') }}
            </h2>
            <a href="{{ route('admin.members.index') }}" class="mt-2 md:mt-0 inline-flex items-center text-sm text-gray-700 hover:text-gray-900">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Members
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Member Info Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $member->name }}</h3>
                            <p class="text-gray-600 text-sm mt-1">{{ $member->email }}</p>
                            <p class="text-gray-600 text-sm mt-1">Member since: {{ $member->created_at->format('d M Y') }}</p>
                        </div>
                        
                        <div class="mt-4 md:mt-0">
                            <form method="POST" action="{{ route('admin.members.destroy', $member) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2" onclick="return confirm('Are you sure you want to suspend this member?')">
                                    Suspend Member
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-4">Member Statistics</h4>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="bg-indigo-50 p-4 rounded-md">
                                <div class="text-sm text-indigo-800 font-medium">Total Bookings</div>
                                <div class="text-2xl font-semibold text-indigo-900 mt-1">{{ $bookings->count() }}</div>
                            </div>
                            
                            <div class="bg-green-50 p-4 rounded-md">
                                <div class="text-sm text-green-800 font-medium">Confirmed Bookings</div>
                                <div class="text-2xl font-semibold text-green-900 mt-1">{{ $bookings->where('status', 'confirmed')->count() }}</div>
                            </div>
                            
                            <div class="bg-blue-50 p-4 rounded-md">
                                <div class="text-sm text-blue-800 font-medium">Completed Bookings</div>
                                <div class="text-2xl font-semibold text-blue-900 mt-1">{{ $bookings->where('status', 'completed')->count() }}</div>
                            </div>
                            
                            <div class="bg-red-50 p-4 rounded-md">
                                <div class="text-sm text-red-800 font-medium">Cancelled Bookings</div>
                                <div class="text-2xl font-semibold text-red-900 mt-1">{{ $bookings->where('status', 'cancelled')->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Member Bookings -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Booking History</h3>
                    
                    @if($bookings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Package</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booked On</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($bookings as $booking)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                #{{ $booking->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $booking->package->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($booking->slot->date)->format('d M Y') }}, 
                                                {{ \Carbon\Carbon::parse($booking->slot->start_time)->format('H:i') }} - 
                                                {{ \Carbon\Carbon::parse($booking->slot->end_time)->format('H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $booking->status === 'completed' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $booking->created_at->format('d M Y, H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('admin.bookings.show', $booking) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            This member has no bookings yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>