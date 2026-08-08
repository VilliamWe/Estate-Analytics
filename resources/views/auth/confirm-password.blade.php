<x-guest-layout>
    <div class="mb-4 text-sm text-slate-600">
        Это защищённый раздел приложения. Подтвердите пароль, чтобы продолжить.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="password" :value="'Пароль'" />

            <x-text-input
                id="password"
                class="mt-1 block w-full"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                autofocus
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end pt-2">
            <x-primary-button>
                Подтвердить пароль
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
