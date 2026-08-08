<x-guest-layout>
    <div class="mb-4 text-sm text-slate-600">
        Спасибо за регистрацию. Перед продолжением подтвердите адрес электронной почты по ссылке из письма.
        Если письмо не пришло, можно отправить его повторно.
    </div>

    @if (session('status') === 'verification-link-sent')
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
            Новая ссылка для подтверждения отправлена на ваш адрес электронной почты.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <x-primary-button>
                Отправить письмо повторно
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button
                type="submit"
                class="text-sm font-medium text-[#1F6F78] underline transition hover:text-[#0F3D3E]"
            >
                Выйти
            </button>
        </form>
    </div>
</x-guest-layout>
