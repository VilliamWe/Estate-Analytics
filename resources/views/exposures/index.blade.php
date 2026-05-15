<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="ea-section-title">Экспозиции</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Размещения объектов по каналам с базовыми метриками и оценкой эффективности.
                </p>
            </div>

            <a href="{{ route('exposures.create') }}" class="ea-btn">
                Добавить экспозицию
            </a>
        </div>
    </x-slot>

    <div class="ea-page">
        <div class="ea-container">
            <div class="mb-6 overflow-hidden rounded-[28px] border border-slate-200 bg-[linear-gradient(135deg,#0F3D3E_0%,#14585A_58%,#1F6F78_100%)] p-6 text-white shadow-[0_24px_60px_rgba(15,61,62,0.18)] sm:p-8">
                <div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr] lg:items-end">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-[0.28em] text-white/60">
                            Exposures
                        </div>
                        <h1 class="mt-4 text-3xl font-semibold leading-tight text-white/90 sm:text-4xl">
                            Управление размещениями и метриками экспозиции
                        </h1>
                        <p class="mt-4 max-w-2xl text-sm leading-7 text-white/80">
                            Контроль каналов размещения, просмотров, обращений и базовой эффективности по каждому объекту.
                        </p>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                            <div class="text-xs uppercase tracking-[0.2em] text-white/60">Фокус</div>
                            <div class="mt-2 text-lg font-semibold">Размещения и каналы</div>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                            <div class="text-xs uppercase tracking-[0.2em] text-white/60">Метрики</div>
                            <div class="mt-2 text-lg font-semibold">Просмотры и обращения</div>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="ea-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="ea-card mb-6">
                <div class="ea-card-body">
                    <div class="mb-5">
                        <h3 class="text-lg font-semibold text-slate-900">Фильтры</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Отберите экспозиции по объекту, каналу, статусу и диапазону даты начала.
                        </p>
                    </div>

                    <form method="GET" action="{{ route('exposures.index') }}" class="grid gap-4 lg:grid-cols-5">
                        <div>
                            <label for="property_id" class="ea-label">Объект</label>
                            <select id="property_id" name="property_id" class="ea-input">
                                <option value="">Все объекты</option>
                                @foreach ($properties as $property)
                                    <option value="{{ $property->id }}" @selected(($filters['property_id'] ?? '') == $property->id)>
                                        {{ $property->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="channel_id" class="ea-label">Канал</label>
                            <select id="channel_id" name="channel_id" class="ea-input">
                                <option value="">Все каналы</option>
                                @foreach ($channels as $channel)
                                    <option value="{{ $channel->id }}" @selected(($filters['channel_id'] ?? '') == $channel->id)>
                                        {{ $channel->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="status" class="ea-label">Статус</label>
                            <select id="status" name="status" class="ea-input">
                                <option value="">Все статусы</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="start_date_from" class="ea-label">Дата начала: от</label>
                            <input
                                id="start_date_from"
                                type="date"
                                name="start_date_from"
                                value="{{ $filters['start_date_from'] ?? '' }}"
                                class="ea-input"
                            >
                        </div>

                        <div>
                            <label for="start_date_to" class="ea-label">Дата начала: до</label>
                            <input
                                id="start_date_to"
                                type="date"
                                name="start_date_to"
                                value="{{ $filters['start_date_to'] ?? '' }}"
                                class="ea-input"
                            >
                        </div>

                        <div class="lg:col-span-5 flex flex-wrap items-center gap-3 pt-2">
                            <button type="submit" class="ea-btn">
                                Применить фильтры
                            </button>

                            <a href="{{ route('exposures.index') }}" class="ea-btn-secondary">
                                Сбросить
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="ea-card">
                <div class="ea-card-body">
                    <div class="mb-5 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">Список экспозиций</h3>
                            <p class="mt-1 text-sm text-slate-500">
                                Мониторинг размещений, просмотров, обращений и текущей эффективности.
                            </p>
                        </div>

                        <div class="text-sm text-slate-500">
                            Найдено: <span class="font-semibold text-slate-700">{{ $exposures->total() }}</span>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="ea-table">
                            <thead>
                                <tr>
                                    <th>Объект</th>
                                    <th>Канал</th>
                                    <th>Создал</th>
                                    <th>Начало</th>
                                    <th>Окончание</th>
                                    <th>Статус</th>
                                    <th>Эффект.</th>
                                    <th>Дней</th>
                                    <th>Просм./день</th>
                                    <th>Обращ./день</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($exposures as $exposure)
                                    <tr>
                                        <td class="font-semibold text-slate-900">{{ $exposure->property?->title }}</td>
                                        <td>{{ $exposure->channel?->title }}</td>
                                        <td>{{ $exposure->creator?->name ?? '—' }}</td>
                                        <td>{{ $exposure->start_date?->format('d.m.Y') }}</td>
                                        <td>{{ $exposure->end_date?->format('d.m.Y') ?? '—' }}</td>
                                        <td>{{ $exposure->status }}</td>
                                        <td>{{ $exposure->efficiency_level }}</td>
                                        <td>{{ $exposure->duration_days }}</td>
                                        <td>{{ number_format($exposure->views_per_day, 2, ',', ' ') }}</td>
                                        <td>{{ number_format($exposure->leads_per_day, 2, ',', ' ') }}</td>
                                        <td>
                                            <div class="flex items-center gap-3 whitespace-nowrap">
                                                <a href="{{ route('exposures.show', $exposure) }}" class="ea-link">
                                                    Открыть
                                                </a>

                                                <a href="{{ route('exposures.edit', $exposure) }}" class="ea-link-warning">
                                                    Редактировать
                                                </a>

                                                <form action="{{ route('exposures.destroy', $exposure) }}" method="POST" onsubmit="return confirm('Удалить экспозицию?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="ea-link-danger">
                                                        Удалить
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13" class="py-8 text-center text-slate-500">
                                            По выбранным фильтрам экспозиции не найдены.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $exposures->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
