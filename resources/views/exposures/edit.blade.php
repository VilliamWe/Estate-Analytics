<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="ea-section-title">Редактирование экспозиции</h2>
            <p class="mt-1 text-sm text-slate-500">
                Изменение данных размещения и его показателей.
            </p>
        </div>
    </x-slot>

    <div class="ea-page">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="mb-6 overflow-hidden rounded-[28px] border border-slate-200 bg-[linear-gradient(135deg,#0F3D3E_0%,#14585A_58%,#1F6F78_100%)] p-6 text-white shadow-[0_24px_60px_rgba(15,61,62,0.18)] sm:p-8">
                <div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr] lg:items-end">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-[0.28em] text-white/60">
                            Exposure Editing
                        </div>
                        <h1 class="mt-4 text-3xl font-semibold leading-tight sm:text-4xl text-white/80">
                            Обновление данных экспозиции
                        </h1>
                        <p class="mt-4 max-w-2xl text-sm leading-7 text-white/80">
                            Скорректируйте канал размещения, даты, статистику и ссылку на объявление.
                        </p>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                            <div class="text-xs uppercase tracking-[0.2em] text-white/60">Фокус</div>
                            <div class="mt-2 text-lg font-semibold">Метрики и статус</div>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                            <div class="text-xs uppercase tracking-[0.2em] text-white/60">Результат</div>
                            <div class="mt-2 text-lg font-semibold">Обновлённая экспозиция</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ea-card">
                <div class="ea-card-body">
                    @if ($errors->any())
                        <div class="ea-alert-error">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('exposures.update', $exposure) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        @include('exposures.partials.form')

                        <div class="flex items-center gap-3">
                            <button type="submit" class="ea-btn">
                                Обновить
                            </button>

                            <a href="{{ route('exposures.show', $exposure) }}" class="ea-btn-secondary">
                                Назад
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
