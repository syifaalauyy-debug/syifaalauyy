<nav x-data="{ open: false }" style="background: linear-gradient(90deg, #FB5802 0%, #FD016B 100%); border-bottom: 1px solid #ffd6e7;">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current" style="color: white;" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" style="color:white;font-weight:600;">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- ⭐ Link Favorit (Desktop) --}}
                    <x-nav-link :href="route('bookmark.index')" :active="request()->routeIs('bookmark.index')" style="color:white;font-weight:600;">
                        ⭐ {{ __('Favorit') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button style="display:inline-flex;align-items:center;padding:6px 12px;border:1px solid rgba(255,255,255,0.4);font-size:14px;font-weight:600;border-radius:8px;color:white;background:rgba(255,255,255,0.15);cursor:pointer;transition:all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" style="color:white;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content" style="background:white;border:1px solid #ffd6e7;border-radius:8px;box-shadow:0 4px 20px rgba(253,1,107,0.15);">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" style="display:inline-flex;align-items:center;justify-content:center;padding:8px;border-radius:6px;color:white;background:rgba(255,255,255,0.2);border:none;cursor:pointer;">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden" style="background: linear-gradient(180deg, #FD016B, #FB5802);">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" style="color:white;font-weight:600;">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            {{-- ⭐ Link Favorit (Mobile) --}}
            <x-responsive-nav-link :href="route('bookmark.index')" :active="request()->routeIs('bookmark.index')" style="color:white;font-weight:600;">
                ⭐ {{ __('Favorit') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div style="padding-top:1rem;padding-bottom:4px;border-top:1px solid rgba(255,255,255,0.3);">
            <div class="px-4">
                <div style="font-weight:700;font-size:1rem;color:white;">{{ Auth::user()->name }}</div>
                <div style="font-size:0.875rem;color:rgba(255,255,255,0.7);">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>