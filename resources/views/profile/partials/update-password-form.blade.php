<section>
    <header>
        <h2 class="text-lg font-semibold text-slate-900">
            Обновление пароля
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Используйте надёжный пароль, чтобы защитить доступ к системе.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div x-data="{ show: false }">
            <x-input-label for="update_password_current_password" :value="'Текущий пароль'" />

            <div class="relative">
                <x-text-input
                    id="update_password_current_password"
                    name="current_password"
                    x-bind:type="show ? 'text' : 'password'"
                    class="mt-1 block w-full pr-12"
                    autocomplete="current-password"
                />

                <button
                    type="button"
                    @click="show = !show"
                    class="absolute inset-y-0 right-0 mt-1 inline-flex items-center px-4 text-slate-400 transition hover:text-slate-600"
                    x-bind:aria-label="show ? 'Скрыть пароль' : 'Показать пароль'"
                >
                    <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        <circle cx="12" cy="12" r="3" stroke-width="1.8"></circle>
                    </svg>

                    <svg x-show="show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3l18 18" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.584 10.587A2 2 0 0012 14a2 2 0 001.414-.586" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.88 5.09A10.94 10.94 0 0112 5c4.478 0 8.268 2.943 9.542 7a11.056 11.056 0 01-4.207 5.217M6.228 6.228A11.024 11.024 0 002.458 12c1.274 4.057 5.065 7 9.542 7a10.97 10.97 0 005.119-1.263" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div x-data="{ show: false }">
            <x-input-label for="update_password_password" :value="'Новый пароль'" />

            <div class="relative">
                <x-text-input
                    id="update_password_password"
                    name="password"
                    x-bind:type="show ? 'text' : 'password'"
                    class="mt-1 block w-full pr-12"
                    autocomplete="new-password"
                />

                <button
                    type="button"
                    @click="show = !show"
                    class="absolute inset-y-0 right-0 mt-1 inline-flex items-center px-4 text-slate-400 transition hover:text-slate-600"
                    x-bind:aria-label="show ? 'Скрыть пароль' : 'Показать пароль'"
                >
                    <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        <circle cx="12" cy="12" r="3" stroke-width="1.8"></circle>
                    </svg>

                    <svg x-show="show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3l18 18" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.584 10.587A2 2 0 0012 14a2 2 0 001.414-.586" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.88 5.09A10.94 10.94 0 0112 5c4.478 0 8.268 2.943 9.542 7a11.056 11.056 0 01-4.207 5.217M6.228 6.228A11.024 11.024 0 002.458 12c1.274 4.057 5.065 7 9.542 7a10.97 10.97 0 005.119-1.263" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div x-data="{ show: false }">
            <x-input-label for="update_password_password_confirmation" :value="'Подтверждение пароля'" />

            <div class="relative">
                <x-text-input
                    id="update_password_password_confirmation"
                    name="password_confirmation"
                    x-bind:type="show ? 'text' : 'password'"
                    class="mt-1 block w-full pr-12"
                    autocomplete="new-password"
                />

                <button
                    type="button"
                    @click="show = !show"
                    class="absolute inset-y-0 right-0 mt-1 inline-flex items-center px-4 text-slate-400 transition hover:text-slate-600"
                    x-bind:aria-label="show ? 'Скрыть пароль' : 'Показать пароль'"
                >
                    <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        <circle cx="12" cy="12" r="3" stroke-width="1.8"></circle>
                    </svg>

                    <svg x-show="show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3l18 18" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.584 10.587A2 2 0 0012 14a2 2 0 001.414-.586" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.88 5.09A10.94 10.94 0 0112 5c4.478 0 8.268 2.943 9.542 7a11.056 11.056 0 01-4.207 5.217M6.228 6.228A11.024 11.024 0 002.458 12c1.274 4.057 5.065 7 9.542 7a10.97 10.97 0 005.119-1.263" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Сохранить</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-slate-500"
                >Сохранено.</p>
            @endif
        </div>
    </form>
</section>
