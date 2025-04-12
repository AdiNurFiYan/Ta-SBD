<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Slots') }}
            </h2>
            <div class="mt-2 md:mt-0 flex space-x-2">
                <a href="{{ route('admin.slots.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Add Single Slot
                </a>
                <button onclick="toggleGenerateForm()" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    Generate Slots
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Generate Slots Form (Hidden by default) -->
            <div id="generate-form" class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6" style="display: none;">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Generate Multiple Slots</h3>
                    <form method="POST" action="{{ route('admin.slots.generate') }}">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                            <div>
                                <label for="package_id" class="block text-sm font-medium text-gray-700">Package</label>
                                <select name="package_id" id="package_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Select Package</option>
                                    @foreach($packages as $pkg)
                                        <option value="{{ $pkg->id }}">{{ $pkg->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                                <input type="date" name="date" id="date" value="{{ $date }}" min="{{ now()->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                            
                            <div>
                                <label for="start_hour" class="block text-sm font-medium text-gray-700">Start Hour (24h)</label>
                                <input type="number" name="start_hour" id="start_hour" value="9" min="0" max="23" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                            
                            <div>
                                <label for="end_hour" class="block text-sm font-medium text-gray-700">End Hour (24h)</label>
                                <input type="number" name="end_hour" id="end_hour" value="21" min="1" max="24" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="button" onclick="toggleGenerateForm()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 mr-3">
                                Cancel
                            </button>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                Generate Slots
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
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
            
            <!-- Filter Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.slots.index') }}" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <label for="package_id" class="block text-sm font-medium text-gray-700">Package</label>
                            <select name="package_id" id="package_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Packages</option>
                                @foreach($packages as $pkg)
                                    <option value="{{ $pkg->id }}" {{ $selectedPackage && $selectedPackage->id == $pkg->id ? 'selected' : '' }}>
                                        {{ $pkg->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="w-full md:w-1/3">
                            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                            <div class="grid grid-cols-2 md:grid-cols-7 gap-2 mt-1">
                                @foreach($dates as $d)
                                    <button type="submit" name="date" value="{{ $d['date'] }}" 
                                        class="text-center p-2 rounded-md border text-sm
                                        {{ $date === $d['date'] ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-gray-200 hover:bg-gray-50 text-gray-700' }}">
                                        {{ \Carbon\Carbon::parse($d['date'])->format('d M') }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="w-full md:w-1/6 self-end">
                            <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Slots List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        Slots for {{ \Carbon\Carbon::parse($date)->format('D, d M Y') }}
                        {{ $selectedPackage ? ' - ' . $selectedPackage->name : '' }}
                    </h3>
                    
                    @if($slots->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($slots as $slot)
                                <div class="border rounded-lg overflow-hidden 
                                    {{ $slot->status === 'available' ? 'border-green-200' : 'border-gray-200' }}
                                    {{ $slot->status === 'booked' ? 'border-red-200' : '' }}
                                    {{ $slot->status === 'maintenance' ? 'border-yellow-200' : '' }}">
                                    <div class="p-4 
                                        {{ $slot->status === 'available' ? 'bg-green-50' : 'bg-gray-50' }}
                                        {{ $slot->status === 'booked' ? 'bg-red-50' : '' }}
                                        {{ $slot->status === 'maintenance' ? 'bg-yellow-50' : '' }}">
                                        <h4 class="font-medium text-gray-900">{{ $slot->package->name }}</h4>
                                        <div class="text-sm text-gray-600 mt-1">
                                            {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                                        </div>
                                        <div class="text-xs mt-1
                                            {{ $slot->status === 'available' ? 'text-green-700' : 'text-gray-700' }}
                                            {{ $slot->status === 'booked' ? 'text-red-700' : '' }}
                                            {{ $slot->status === 'maintenance' ? 'text-yellow-700' : '' }}">
                                            {{ ucfirst($slot->status) }}
                                        </div>
                                    </div>
                                    <div class="p-2 flex justify-between items-center">
                                        <a href="{{ route('admin.slots.edit', $slot) }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.slots.destroy', $slot) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to remove this slot?')">
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            No slots found for the selected criteria.
                            <div class="mt-4">
                                <a href="{{ route('admin.slots.create') }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Create a slot</a>
                                or
                                <button type="button" onclick="toggleGenerateForm()" class="text-green-600 hover:text-green-900 ml-1">Generate slots</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleGenerateForm() {
            const form = document.getElementById('generate-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</x-admin-app-layout>