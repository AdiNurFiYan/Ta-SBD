<x-member-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('PlayStation Packages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filter -->
            {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form action="{{ route('member.packages.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Search by name...">
                        </div>
                        
                        <div class="w-full md:w-1/4">
                            <label for="min_price" class="block text-sm font-medium text-gray-700">Min Price</label>
                            <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Min price">
                        </div>
                        
                        <div class="w-full md:w-1/4">
                            <label for="max_price" class="block text-sm font-medium text-gray-700">Max Price</label>
                            <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Max price">
                        </div>
                        
                        <div class="self-end">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div> --}}

            <!-- Packages List -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($packages as $package)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $package->name }}</h3>
                            <div class="mt-2">
                                <span class="text-2xl font-bold text-gray-900">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                                <span class="text-gray-500 text-sm">/ {{ $package->duration }} hour(s)</span>
                            </div>
                            
                            <div class="mt-4 text-sm text-gray-600">
                                <p>{{ Str::limit($package->description, 100) }}</p>
                            </div>
                            
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-900">Facilities:</h4>
                                <p class="text-sm text-gray-600">{{ $package->facilities }}</p>
                            </div>
                            
                            <div class="mt-6">
                                <a href="{{ route('member.slots.index', $package) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Check Availability
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center">
                            <p class="text-gray-500">No packages found.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-member-app-layout>