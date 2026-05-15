<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="'Электронная почта'" />
            <x-text-input
                id="email"
                class="mt-1 block w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div x-data="{ showPassword: false }">
            <x-input-label for="password" :value="'Пароль'" />

            <div class="relative mt-1">
                <x-text-input
                    id="password"
                    class="block w-full pr-12"
                    x-bind:type="showPassword ? 'text' : 'password'"
                    name="password"
                    required
                    autocomplete="current-password"
                />

                <button
                    type="button"
                    @click="showPassword = !showPassword"
                    class="absolute inset-y-0 right-0 inline-flex items-center px-4 text-slate-400 transition hover:text-[#0F3D3E] focus:outline-none"
                    :aria-label="showPassword ? 'Скрыть пароль' : 'Показать пароль'"
                >
                    <svg x-show="!showPassword" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 15.5A3.5 3.5 0 1 0 12 8.5a3.5 3.5 0 0 0 0 7Z" />
                    </svg>

                    <svg x-show="showPassword" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="m3 3 18 18" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M10.584 10.587A2 2 0 0 0 13.414 13.4" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M9.364 5.365A9.954 9.954 0 0 1 12 5c4.478 0 8.268 2.943 9.542 7a9.956 9.956 0 0 1-4.125 5.246" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M6.673 6.676A9.963 9.963 0 0 0 2.458 12c1.274 4.057 5.064 7 9.542 7 1.64 0 3.187-.395 4.548-1.094" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between gap-4 pt-2">
            @if (Route::has('password.request'))
                <a
                    class="text-sm font-medium text-[#1F6F78] transition hover:text-[#0F3D3E]"
                    href="{{ route('password.request') }}"
                >
                    Забыли пароль?
                </a>
            @endif

            <x-primary-button class="justify-center border border-[#0B2F30] hover:border-[#14585A] active:border-[#4D8F95]">
                Войти
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
