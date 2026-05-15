<x-guest-layout>
    <div class="mb-4 text-sm leading-6 text-slate-600">
        Забыли пароль? Укажите адрес электронной почты, и система отправит ссылку для восстановления доступа.
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="'Электронная почта'" />
            <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required
                autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between gap-4 pt-2">
            <a class="text-sm font-medium text-[#1F6F78] transition hover:text-[#0F3D3E]" href="{{ route('login') }}">
                Назад
            </a>

            <x-primary-button>
                Отправить ссылку
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>