<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="ea-section-title">Карточка экспозиции</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Подробная информация по размещению, его показателям и итоговой оценке.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('exposures.print', $exposure) }}" target="_blank" class="ea-btn-secondary">
                    Печать / PDF
                </a>

                <a href="{{ route('exposures.edit', $exposure) }}" class="ea-btn-warning">
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

            @php($backUrl = url()->previous() !== url()->current() ? url()->previous() : route('exposures.index'))

            <div class="mb-4">
                <a href="{{ $backUrl }}" class="ea-btn-secondary">
                    Назад к списку экспозиций
                </a>
            </div>

            <div class="mb-6 overflow-hidden rounded-[28px] border border-slate-200 bg-[linear-gradient(135deg,#0F3D3E_0%,#14585A_58%,#1F6F78_100%)] p-6 text-white shadow-[0_24px_60px_rgba(15,61,62,0.18)] sm:p-8">
                <div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr] lg:items-end">
                    <div class="min-w-0">
                        <div class="text-[11px] font-semibold uppercase tracking-[0.18em] leading-none text-white/70">
                            Exposure Card
                        </div>
                        <h1 class="mt-4 text-3xl font-semibold leading-tight text-white/90 sm:text-4xl">
                            {{ $exposure->property?->title ?? 'Экспозиция' }}
                        </h1>
                        <p class="mt-4 max-w-2xl text-sm leading-7 text-white/80">
                            Подробный обзор канала размещения, периода публикации и аналитических метрик.
                        </p>
                    </div>

                    <div class="grid min-w-0 gap-3 sm:grid-cols-2">
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                            <div class="text-xs uppercase tracking-[0.2em] text-white/60">Канал</div>
                            <div class="mt-2 text-lg font-semibold">{{ $exposure->channel?->title ?? '—' }}</div>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                            <div class="text-xs uppercase tracking-[0.2em] text-white/60">Статус</div>
                            <div class="mt-2 text-lg font-semibold">{{ $exposure->status }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ea-card">
                <div class="grid gap-6 p-6 lg:grid-cols-[0.9fr_1.1fr]">
                    <div class="min-w-0">
                        <h3 class="mb-4 text-lg font-semibold text-slate-900">Основная информация</h3>

                        <dl class="space-y-4 text-sm">
                            <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] px-4 py-3">
                                <dt class="font-medium text-slate-500">Объект</dt>
                                <dd class="mt-1 text-slate-900">{{ $exposure->property?->title }}</dd>
                            </div>

                            <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] px-4 py-3">
                                <dt class="font-medium text-slate-500">Канал размещения</dt>
                                <dd class="mt-1 text-slate-900">{{ $exposure->channel?->title }}</dd>
                            </div>

                            <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] px-4 py-3">
                                <dt class="font-medium text-slate-500">Статус</dt>
                                <dd class="mt-1 text-slate-900">{{ $exposure->status }}</dd>
                            </div>

                            <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] px-4 py-3">
                                <dt class="font-medium text-slate-500">Кто создал запись</dt>
                                <dd class="mt-1 text-slate-900">{{ $exposure->creator?->name ?? '—' }}</dd>
                            </div>

                            <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] px-4 py-3">
                                <dt class="font-medium text-slate-500">Дата начала</dt>
                                <dd class="mt-1 text-slate-900">{{ $exposure->start_date?->format('d.m.Y') }}</dd>
                            </div>

                            <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] px-4 py-3">
                                <dt class="font-medium text-slate-500">Дата окончания</dt>
                                <dd class="mt-1 text-slate-900">{{ $exposure->end_date?->format('d.m.Y') ?? '—' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="min-w-0">
                        <h3 class="mb-4 text-lg font-semibold text-slate-900">Показатели</h3>

                        <div class="ea-stat-grid">
                            <div class="ea-stat-card">
                                <div class="ea-stat-label">Цена размещения</div>
                                <div class="ea-stat-value">{{ number_format($exposure->publication_price ?? 0, 2, ',', ' ') }}</div>
                            </div>

                            <div class="ea-stat-card">
                                <div class="ea-stat-label">Просмотры</div>
                                <div class="ea-stat-value">{{ $exposure->views_count }}</div>
                            </div>

                            <div class="ea-stat-card">
                                <div class="ea-stat-label">Обращения</div>
                                <div class="ea-stat-value">{{ $exposure->leads_count }}</div>
                            </div>

                            <div class="ea-stat-card">
                                <div class="ea-stat-label">Длительность, дней</div>
                                <div class="ea-stat-value">{{ $exposure->duration_days }}</div>
                            </div>

                            <div class="ea-stat-card">
                                <div class="ea-stat-label">Просмотры в день</div>
                                <div class="ea-stat-value">{{ number_format($exposure->views_per_day, 2, ',', ' ') }}</div>
                            </div>

                            <div class="ea-stat-card">
                                <div class="ea-stat-label">Обращения в день</div>
                                <div class="ea-stat-value">{{ number_format($exposure->leads_per_day, 2, ',', ' ') }}</div>
                            </div>

                            <div class="ea-stat-card">
                                <div class="ea-stat-label">Отклонение цены, %</div>
                                <div class="ea-stat-value">{{ number_format($exposure->price_deviation_percent, 2, ',', ' ') }}</div>
                            </div>

                            <div class="ea-stat-card">
                                <div class="ea-stat-label">Эффективность</div>
                                <div class="ea-stat-value">{{ ucfirst($exposure->efficiency_level) }}</div>
                            </div>
                        </div>

                        <div class="mt-4 min-w-0 rounded-2xl border border-slate-100 bg-[#FAFCFC] px-4 py-3 text-sm text-slate-600">
                            Ссылка:
                            @if ($exposure->source_url)
                                <a href="#" class="ea-link break-all">
                                    {{ $exposure->source_url }}
                                </a>
                            @else
                                —
                            @endif
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-200 p-6">
                    <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">
                                Оценка канала
                            </h3>
                            <p class="mt-1 text-sm text-slate-500">
                                Внутреннее сравнение с похожими размещениями по тому же каналу, типу объекта и району.
                            </p>
                        </div>

                        <div class="text-sm text-slate-500">
                            Сопоставимых размещений: <span class="font-semibold text-slate-700">{{ $channelInsight['benchmark_count'] }}</span>
                        </div>
                    </div>

                    <div class="grid gap-4 lg:grid-cols-3">
                        <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] p-4">
                            <div class="text-sm font-medium text-slate-500">Позиция канала</div>
                            <div class="mt-2 text-lg font-semibold text-slate-900">{{ $channelInsight['channel_position'] }}</div>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $channelInsight['channel_message'] }}</p>
                        </div>

                        <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] p-4">
                            <div class="text-sm font-medium text-slate-500">Средние показатели</div>
                            <div class="mt-2 text-sm leading-7 text-slate-700">
                                <div>Просмотры в день: {{ number_format($channelInsight['avg_views_per_day'], 2, ',', ' ') }}</div>
                                <div>Обращения в день: {{ number_format($channelInsight['avg_leads_per_day'], 2, ',', ' ') }}</div>
                                <div>Отклонение по просмотрам: {{ number_format($channelInsight['views_delta_percent'], 2, ',', ' ') }}%</div>
                                <div>Отклонение по обращениям: {{ number_format($channelInsight['leads_delta_percent'], 2, ',', ' ') }}%</div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] p-4">
                            <div class="text-sm font-medium text-slate-500">Рекомендация</div>
                            <div class="mt-2 text-lg font-semibold text-slate-900">{{ $channelInsight['recommendation_title'] }}</div>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $channelInsight['recommendation_text'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-200 p-6">
                    <h3 class="mb-3 text-lg font-semibold text-slate-900">Комментарий</h3>

                    <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] px-4 py-4 text-sm leading-7 text-slate-700">
                        {{ $exposure->comment ?: 'Комментарий не заполнен.' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
