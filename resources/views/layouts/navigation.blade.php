<nav x-data="{ open: false }" class="bg-blue-50 border-b border-blue-200">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('post_index') }}">
                        <img src="{{ asset('images/my_logo.png') }}" alt="{{ config('app.name', 'Laravel') }}" class="h-12">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex space-x-8 sm:-my-px sm:ms-10">
                    <x-nav-link :href="route('show', ['user' => Auth::user()->id])" :active="request()->routeIs('/users/{user}')" class="text-blue-600 hover:text-blue-800">
                        {{ __('Profile') }}
                    </x-nav-link>
                    <x-nav-link :href="route('my_posts')" :active="request()->routeIs('/posts/my_posts')" class="text-blue-600 hover:text-blue-800">
                        {{ __('My Posts') }}
                    </x-nav-link>
                    <x-nav-link :href="route('likeshow')" :active="request()->routeIs('/posts/like/show')" class="text-blue-600 hover:text-blue-800">
                        {{ __('Favorites') }}
                    </x-nav-link>
                    <x-nav-link :href="route('communities_index')" :active="request()->routeIs('/communities/index')" class="text-blue-600 hover:text-blue-800">
                        {{ __('Community') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-600 bg-white hover:bg-blue-100 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="text-blue-600 hover:bg-blue-100">
                            {{ __('Settings') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                this.closest('form').submit();" class="text-blue-600 hover:bg-blue-100">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-blue-400 hover:text-blue-600 hover:bg-blue-100 focus:outline-none focus:bg-blue-100 focus:text-blue-600 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 bg-blue-50">
            <x-responsive-nav-link :href="route('show', ['user' => Auth::user()->id])" :active="request()->routeIs('/users/{user}')" class="text-blue-600 hover:bg-blue-100">
                {{ __('Profile') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('my_posts')" :active="request()->routeIs('/posts/my_posts')" class="text-blue-600 hover:bg-blue-100">
                {{ __('My Posts') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('likeshow')" :active="request()->routeIs('/posts/like/show')" class="text-blue-600 hover:bg-blue-100">
                {{ __('Favorites') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('communities_index')" :active="request()->routeIs('/communities/index')" class="text-blue-600 hover:bg-blue-100">
                {{ __('Community') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-blue-200 bg-blue-50">
            <div class="px-4">
                <div class="font-medium text-base text-blue-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-blue-500">{{ Auth::user()->email }}</div>
            </div>
            
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-blue-600 hover:bg-blue-100">
                    {{ __('Settings') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                        this.closest('form').submit();" class="text-blue-600 hover:bg-blue-100">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
