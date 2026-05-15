<nav x-data="{ open: false }"
    class="border-b border-slate-200/80 bg-white/90 backdrop-blur-md shadow-[0_10px_30px_rgba(15,61,62,0.06)]">
    <div class="mx-auto max-w-[88rem] px-4 sm:px-6 lg:px-8">
        <div class="flex h-[72px] justify-between">
            <div class="flex">
                <div class="flex shrink-0 items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-3 text-slate-800">
                        <span
                            class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-[#0F3D3E] text-sm font-bold tracking-[0.18em] text-white shadow-[0_10px_25px_rgba(15,61,62,0.22)]">
                            EA
                        </span>

                        <span class="flex flex-col">
                            <span class="text-base font-semibold leading-tight text-slate-900">
                                Estate Analytics
                            </span>
                        </span>
                    </a>
                </div>

                <div class="hidden items-center gap-2 sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    <x-nav-link :href="route('properties.index')" :active="request()->routeIs('properties.*')">
                        Объекты
                    </x-nav-link>

                    <x-nav-link :href="route('exposures.index')" :active="request()->routeIs('exposures.*')">
                        Экспозиции
                    </x-nav-link>

                    <x-nav-link :href="route('analytics.index')" :active="request()->routeIs('analytics.index')">
                        Аналитика
                    </x-nav-link>

                    <x-nav-link :href="route('comparison.index')" :active="request()->routeIs('comparison.index')">
                        Сравнение
                    </x-nav-link>

                    <x-nav-link :href="route('imports.index')" :active="request()->routeIs('imports.*')">
                        Импорт
                    </x-nav-link>

                    @if (auth()->user()?->role === 'admin')
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                            Пользователи
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:ms-6 sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            type="button"
                            class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium leading-4 text-slate-600 shadow-sm transition hover:border-slate-300 hover:text-slate-800 focus:outline-none">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="h-4 w-4 fill-current text-slate-400" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Профиль
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Выйти
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white p-2 text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-[#0F3D3E] focus:bg-slate-50 focus:text-[#0F3D3E] focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <path x-show="!open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                            stroke="#0F3D3E" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                            stroke="#0F3D3E" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-cloak x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2" class="border-t border-slate-200 bg-white sm:hidden">
        <div class="space-y-1 pb-3 pt-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('properties.index')" :active="request()->routeIs('properties.*')">
                Объекты
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('exposures.index')" :active="request()->routeIs('exposures.*')">
                Экспозиции
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('analytics.index')" :active="request()->routeIs('analytics.index')">
                Аналитика
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('comparison.index')" :active="request()->routeIs('comparison.index')">
                Сравнение
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('imports.index')" :active="request()->routeIs('imports.*')">
                Импорт
            </x-responsive-nav-link>

            @if (auth()->user()?->role === 'admin')
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                    Пользователи
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="border-t border-slate-200 pb-3 pt-4">
            <div class="px-4">
                <div class="text-base font-medium text-slate-800">{{ Auth::user()->name }}</div>
                <div class="text-sm font-medium text-slate-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                    Профиль
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Выйти
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
