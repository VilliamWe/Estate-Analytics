<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="ea-section-title">Карточка объекта</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Подробная информация по объекту, его показателям и связанным экспозициям.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('properties.print', $property) }}" target="_blank" class="ea-btn-secondary">
                    Печать / PDF
                </a>

                <a href="{{ route('properties.edit', $property) }}" class="ea-btn-warning">
                    Редактировать
                </a>
            </div>
        </div>
    </x-slot>

    <div class="ea-page">
        <div class="ea-container">
            @if (session('success'))
                <div class="ea-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @php($backUrl = url()->previous() !== url()->current() ? url()->previous() : route('properties.index'))

            <div class="mb-4">
                <a href="{{ $backUrl }}" class="ea-btn-secondary">
                    Назад к списку объектов
                </a>
            </div>

            <div class="mb-6 overflow-hidden rounded-[28px] border border-slate-200 bg-[linear-gradient(135deg,#0F3D3E_0%,#14585A_58%,#1F6F78_100%)] p-6 text-white shadow-[0_24px_60px_rgba(15,61,62,0.18)] sm:p-8">
                <div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr] lg:items-end">
                    <div>
                        <div class="text-[11px] font-semibold uppercase tracking-[0.18em] leading-none text-white/70">
                            Property Card
                        </div>
                        <h1 class="mt-4 text-3xl font-semibold leading-tight text-white/90 sm:text-4xl">
                            {{ $property->title }}
                        </h1>
                        <p class="mt-4 max-w-2xl text-sm leading-7 text-white/80">
                            Подробный обзор параметров объекта, текущего статуса и агрегированных показателей по экспозициям.
                        </p>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                            <div class="text-xs uppercase tracking-[0.2em] text-white/60">Район</div>
                            <div class="mt-2 text-lg font-semibold">{{ $property->district?->title ?? '—' }}</div>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                            <div class="text-xs uppercase tracking-[0.2em] text-white/60">Статус</div>
                            <div class="mt-2 text-lg font-semibold">{{ $property->status }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ea-card">
                <div class="grid gap-6 p-6 lg:grid-cols-[0.95fr_1.05fr]">
                    <div>
                        <h3 class="mb-4 text-lg font-semibold text-slate-900">
                            Основная информация
                        </h3>

                        <dl class="space-y-4 text-sm">
                            <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] px-4 py-3">
                                <dt class="font-medium text-slate-500">Название</dt>
                                <dd class="mt-1 text-slate-900">{{ $property->title }}</dd>
                            </div>

                            <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] px-4 py-3">
                                <dt class="font-medium text-slate-500">Тип объекта</dt>
                                <dd class="mt-1 text-slate-900">{{ $property->propertyType?->title }}</dd>
                            </div>

                            <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] px-4 py-3">
                                <dt class="font-medium text-slate-500">Район</dt>
                                <dd class="mt-1 text-slate-900">{{ $property->district?->title }}</dd>
                            </div>

                            <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] px-4 py-3">
                                <dt class="font-medium text-slate-500">Сегмент</dt>
                                <dd class="mt-1 text-slate-900">{{ $property->segment ?: '—' }}</dd>
                            </div>

                            <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] px-4 py-3">
                                <dt class="font-medium text-slate-500">Адрес</dt>
                                <dd class="mt-1 text-slate-900">{{ $property->address }}</dd>
                            </div>

                            <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] px-4 py-3">
                                <dt class="font-medium text-slate-500">Статус</dt>
                                <dd class="mt-1 text-slate-900">{{ $property->status }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div>
                        <h3 class="mb-4 text-lg font-semibold text-slate-900">
                            Показатели объекта
                        </h3>

                        <div class="ea-stat-grid">
                            <div class="ea-stat-card">
                                <div class="ea-stat-label">Площадь</div>
                                <div class="ea-stat-value">{{ number_format($property->area, 2, ',', ' ') }} м²</div>
                            </div>

                            <div class="ea-stat-card">
                                <div class="ea-stat-label">Цена</div>
                                <div class="ea-stat-value">{{ number_format($property->price, 2, ',', ' ') }}</div>
                            </div>

                            <div class="ea-stat-card">
                                <div class="ea-stat-label">Цена за кв. м</div>
                                <div class="ea-stat-value">{{ number_format($property->price_per_sqm, 2, ',', ' ') }}</div>
                            </div>

                            <div class="ea-stat-card">
                                <div class="ea-stat-label">Ответственный</div>
                                <div class="ea-stat-value">{{ $property->responsibleUser?->name }}</div>
                            </div>

                            <div class="ea-stat-card">
                                <div class="ea-stat-label">Активные экспозиции</div>
                                <div class="ea-stat-value">{{ $activeExposuresCount }}</div>
                            </div>

                            <div class="ea-stat-card">
                                <div class="ea-stat-label">Общие просмотры</div>
                                <div class="ea-stat-value">{{ $totalViews }}</div>
                            </div>

                            <div class="ea-stat-card">
                                <div class="ea-stat-label">Общие обращения</div>
                                <div class="ea-stat-value">{{ $totalLeads }}</div>
                            </div>

                            <div class="ea-stat-card">
                                <div class="ea-stat-label">Итоговая эффективность</div>
                                <div class="ea-stat-value">{{ ucfirst($property->efficiency_level) }}</div>
                            </div>
                        </div>

                        <div class="mt-4 rounded-2xl border border-slate-100 bg-[#FAFCFC] px-4 py-3 text-sm text-slate-600">
                            Дата добавления: {{ $property->created_at?->format('d.m.Y H:i') }}
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-200 p-6">
                    <h3 class="mb-3 text-lg font-semibold text-slate-900">
                        Описание
                    </h3>

                    <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] px-4 py-4 text-sm leading-7 text-slate-700">
                        {{ $property->description ?: 'Описание не заполнено.' }}
                    </div>
                </div>

                <div class="border-t border-slate-200 p-6">
                    <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">
                                Рыночная оценка
                            </h3>
                            <p class="mt-1 text-sm text-slate-500">
                                Быстрая аналитика по вашей внутренней базе аналогичных объектов.
                            </p>
                        </div>

                        <div class="text-sm text-slate-500">
                            Аналогов в базе: <span class="font-semibold text-slate-700">{{ $marketInsight['similar_count'] }}</span>
                        </div>
                    </div>

                    <div class="grid gap-4 lg:grid-cols-3">
                        <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] p-4">
                            <div class="text-sm font-medium text-slate-500">Позиция относительно рынка</div>
                            <div class="mt-2 text-lg font-semibold text-slate-900">{{ $marketInsight['market_position'] }}</div>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $marketInsight['market_message'] }}</p>
                        </div>

                        <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] p-4">
                            <div class="text-sm font-medium text-slate-500">Средняя цена по аналогам</div>
                            <div class="mt-2 text-lg font-semibold text-slate-900">
                                {{ number_format($marketInsight['avg_price_per_sqm'], 2, ',', ' ') }}
                            </div>
                            <p class="mt-2 text-sm leading-6 text-slate-600">
                                Отклонение текущего объекта: {{ number_format($marketInsight['price_delta_percent'], 2, ',', ' ') }}%
                            </p>
                        </div>

                        <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] p-4">
                            <div class="text-sm font-medium text-slate-500">Перспектива объекта</div>
                            <div class="mt-2 text-lg font-semibold text-slate-900">{{ $marketInsight['outlook_label'] }}</div>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $marketInsight['outlook_message'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-200 p-6">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-slate-900">
                            Похожие объекты
                        </h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Система подбирает аналоги по типу объекта, району, площади и цене за квадратный метр.
                        </p>
                    </div>

                    @if ($similarProperties->isNotEmpty())
                        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                            @foreach ($similarProperties as $similarProperty)
                                <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] p-4">
                                    <div class="text-sm font-semibold text-slate-900">
                                        {{ $similarProperty->title }}
                                    </div>
                                    <div class="mt-2 text-sm text-slate-500">
                                        {{ $similarProperty->district?->title }} · {{ $similarProperty->propertyType?->title }}
                                    </div>
                                    <div class="mt-3 space-y-1 text-sm text-slate-600">
                                        <div>Площадь: {{ number_format($similarProperty->area, 2, ',', ' ') }} м²</div>
                                        <div>Цена за кв. м: {{ number_format($similarProperty->price_per_sqm, 2, ',', ' ') }}</div>
                                        <div>Статус: {{ $similarProperty->status }}</div>
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ route('properties.show', $similarProperty) }}" class="ea-link">
                                            Открыть аналог
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] px-4 py-4 text-sm text-slate-600">
                            Для этого объекта пока не найдено похожих аналогов в текущей базе.
                        </div>
                    @endif
                </div>

                <div class="border-t border-slate-200 p-6">
                    <div class="mb-4 flex items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">
                                Экспозиции объекта
                            </h3>
                            <p class="mt-1 text-sm text-slate-500">
                                Все размещения, связанные с этим объектом.
                            </p>
                        </div>

                        <a href="{{ route('exposures.create') }}" class="ea-btn-secondary">
                            Добавить экспозицию
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="ea-table">
                            <thead>
                                <tr>
                                    <th>Канал</th>
                                    <th>Дата начала</th>
                                    <th>Дата окончания</th>
                                    <th>Просмотры</th>
                                    <th>Обращения</th>
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($property->exposures as $exposure)
                                    <tr>
                                        <td>{{ $exposure->channel?->title }}</td>
                                        <td>{{ $exposure->start_date?->format('d.m.Y') }}</td>
                                        <td>{{ $exposure->end_date?->format('d.m.Y') ?? '—' }}</td>
                                        <td>{{ $exposure->views_count }}</td>
                                        <td>{{ $exposure->leads_count }}</td>
                                        <td>{{ $exposure->status }}</td>
                                        <td>
                                            <div class="flex items-center gap-3 whitespace-nowrap">
                                                <a href="{{ route('exposures.show', $exposure) }}" class="ea-link">
                                                    Открыть
                                                </a>

                                                <a href="{{ route('exposures.edit', $exposure) }}" class="ea-link-warning">
                                                    Редактировать
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-8 text-center text-slate-500">
                                            Для этого объекта пока нет экспозиций.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
