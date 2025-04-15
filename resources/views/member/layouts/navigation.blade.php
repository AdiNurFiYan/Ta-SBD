<!-- navigation.blade.php -->

<nav x-data="{ open: false }" class="bg-[#FFF8F8] border-b border-[#E9DFC3]">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('member.dashboard') }}">
                        <span class="font-bold text-3xl text-[#0118D8]">RePlayy</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('member.dashboard')" :active="request()->routeIs('member.dashboard')" class="text-lg font-medium {{ request()->routeIs('member.dashboard') ? 'text-[#0118D8] border-b-4 border-[#0118D8]' : 'text-gray-600 hover:text-[#1B56FD]' }}">
                        <div class="flex items-center space-x-2 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>{{ __('Home') }}</span>
                        </div>
                    </x-nav-link>
                    
                    <x-nav-link :href="route('member.packages.index')" :active="request()->routeIs('member.packages.*')" class="text-lg font-medium {{ request()->routeIs('member.packages.*') ? 'text-[#0118D8] border-b-4 border-[#0118D8]' : 'text-gray-600 hover:text-[#1B56FD]' }}">
                        <div class="flex items-center space-x-2 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                            <span>{{ __('Packages') }}</span>
                        </div>
                    </x-nav-link>
                    
                    <x-nav-link :href="route('member.bookings.history')" :active="request()->routeIs('member.bookings.*')" class="text-lg font-medium {{ request()->routeIs('member.bookings.*') ? 'text-[#0118D8] border-b-4 border-[#0118D8]' : 'text-gray-600 hover:text-[#1B56FD]' }}">
                        <div class="flex items-center space-x-2 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ __('My Bookings') }}</span>
                        </div>
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="inline-flex items-center bg-[#E9DFC3] rounded-full px-4 py-2 shadow-md">
                    <span class="text-gray-700 mr-3 font-medium">{{ Auth::guard('member')->user()->name }}</span>
                    <form method="POST" action="{{ route('member.logout') }}">
                        @csrf
                        <button type="submit" class="text-base font-medium text-[#0118D8] hover:text-[#1B56FD] focus:outline-none transition ease-in-out duration-150 flex items-center">
                            <span>{{ __('Log Out') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-[#0118D8] hover:bg-[#E9DFC3] focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 bg-[#FFF8F8]">
            <x-responsive-nav-link :href="route('member.dashboard')" :active="request()->routeIs('member.dashboard')" class="{{ request()->routeIs('member.dashboard') ? 'bg-[#E9DFC3] text-[#0118D8]' : 'text-gray-600' }} flex items-center space-x-3 px-4 py-3 text-lg font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>{{ __('Home') }}</span>
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('member.packages.index')" :active="request()->routeIs('member.packages.*')" class="{{ request()->routeIs('member.packages.*') ? 'bg-[#E9DFC3] text-[#0118D8]' : 'text-gray-600' }} flex items-center space-x-3 px-4 py-3 text-lg font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
                <span>{{ __('Packages') }}</span>
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('member.bookings.history')" :active="request()->routeIs('member.bookings.*')" class="{{ request()->routeIs('member.bookings.*') ? 'bg-[#E9DFC3] text-[#0118D8]' : 'text-gray-600' }} flex items-center space-x-3 px-4 py-3 text-lg font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>{{ __('My Bookings') }}</span>
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-4 border-t border-[#E9DFC3] bg-[#FFF8F8]">
            <div class="px-4 py-2 bg-[#E9DFC3] mx-4 rounded-lg">
                <div class="font-medium text-lg text-gray-800">{{ Auth::guard('member')->user()->name }}</div>
                <div class="font-medium text-sm text-gray-600">{{ Auth::guard('member')->user()->email }}</div>
            </div>

            <div class="mt-4 px-4">
                <!-- Authentication -->
                <form method="POST" action="{{ route('member.logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('member.logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="bg-[#0118D8] text-white px-4 py-3 rounded-lg text-center flex justify-center items-center space-x-2">
                        <span>{{ __('Log Out') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>