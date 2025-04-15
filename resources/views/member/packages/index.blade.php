<!-- packages.blade.php -->

<x-member-app-layout>
<x-slot name="header">
    <h2 class="font-bold text-2xl text-[#0118D8] leading-tight flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#0118D8] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
        </svg>
        {{ __('PlayStation Packages') }}
    </h2>
</x-slot>

    <div class="py-12 bg-[#FFF8F8]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Title Section -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-[#0118D8] mb-3">Choose Your Gaming Experience</h1>
                <p class="text-xl text-gray-700">Select from our premium PlayStation packages and book your session today!</p>
            </div>

            <!-- Packages List -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                @forelse($packages as $package)
                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border-2 border-[#E9DFC3] hover:shadow-xl transition-shadow duration-300 relative flex flex-col h-full">
                        <div class="p-6 flex-grow">
                            <h3 class="text-xl font-bold text-[#0118D8]">{{ $package->name }}</h3>
                            <div class="mt-3 flex items-center">
                                <span class="text-3xl font-bold text-gray-900">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                                <span class="text-gray-600 text-lg ml-2">/ {{ $package->duration }} hour(s)</span>
                            </div>
                            <div class="mt-4 text-base text-gray-700">
                                <p>{{ Str::limit($package->description, 100) }}</p>
                            </div>
                            <div class="mt-5 bg-[#FFF8F8] p-4 rounded-lg">
                                <h4 class="text-base font-semibold text-gray-800 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#1B56FD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Facilities:
                                </h4>
                                <p class="text-base text-gray-700 mt-1">{{ $package->facilities }}</p>
                            </div>
                        </div>
                        <div class="p-6 pt-2 mt-auto">
                            <a href="{{ route('member.slots.index', $package) }}" class="block w-full text-center px-6 py-3 bg-[#0118D8] border border-transparent rounded-xl font-bold text-base text-white tracking-wide hover:bg-[#1B56FD] focus:outline-none focus:ring-2 focus:ring-[#1B56FD] focus:ring-offset-2 transition ease-in-out duration-150 shadow-md flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Check Availability
                            </a>
                        </div>
                        <div class="absolute top-0 right-0 bg-[#E9DFC3] px-4 py-2 rounded-bl-xl">
                            <div class="flex items-center text-gray-800 font-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $package->duration }} hour(s)
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white overflow-hidden shadow-lg sm:rounded-xl border-2 border-[#E9DFC3]">
                        <div class="p-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 13a4 4 0 100-8 4 4 0 000 8z" />
                            </svg>
                            <p class="text-gray-600 text-xl">No packages found.</p>
                            <p class="text-gray-500 mt-2">Please check back later or contact support.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-member-app-layout>