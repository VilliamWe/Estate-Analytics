<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="ea-section-title">Dashboard</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Краткий обзор объектов, экспозиций и текущих показателей системы.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="ea-page">
        <div class="ea-container">
            <div class="mb-6 overflow-hidden rounded-[28px] border border-slate-200 bg-[linear-gradient(135deg,#0F3D3E_0%,#14585A_58%,#1F6F78_100%)] p-6 text-white shadow-[0_24px_60px_rgba(15,61,62,0.18)] sm:p-8">
                <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr] lg:items-end">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-[0.28em] text-white/60">
                            Estate Analytics
                        </div>
                        <h1 class="mt-4 text-3xl font-semibold leading-tight sm:text-4xl text-white/80">
                            Единая рабочая панель по коммерческой недвижимости
                        </h1>
                        <p class="mt-4 max-w-2xl text-sm leading-7 text-white/80">
                            Просматривайте ключевые метрики, оценивайте активность объектов и
                            переходите к основным разделам системы из одной точки входа.
                        </p>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                            <div class="text-xs uppercase tracking-[0.2em] text-white/60">Объекты</div>
                            <div class="mt-2 text-3xl font-semibold">{{ $totalProperties }}</div>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                            <div class="text-xs uppercase tracking-[0.2em] text-white/60">Экспозиции</div>
                            <div class="mt-2 text-3xl font-semibold">{{ $totalExposures }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="ea-card">
                    <div class="ea-card-body">
                        <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">
                            Всего объектов
                        </div>
                        <div class="mt-3 text-3xl font-semibold text-slate-900">
                            {{ $totalProperties }}
                        </div>
                        <div class="mt-2 text-sm text-slate-500">
                            Все записи в реестре недвижимости.
                        </div>
                    </div>
                </div>

                <div class="ea-card">
                    <div class="ea-card-body">
                        <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">
                            Активные объекты
                        </div>
                        <div class="mt-3 text-3xl font-semibold text-slate-900">
                            {{ $activeProperties }}
                        </div>
                        <div class="mt-2 text-sm text-slate-500">
                            Объекты, находящиеся в работе.
                        </div>
                    </div>
                </div>

                <div class="ea-card">
                    <div class="ea-card-body">
                        <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">
                            Средняя цена
                        </div>
                        <div class="mt-3 text-3xl font-semibold text-slate-900">
                            {{ number_format($averagePrice, 2, ',', ' ') }}
                        </div>
                        <div class="mt-2 text-sm text-slate-500">
                            Средняя стоимость объекта в системе.
                        </div>
                    </div>
                </div>

                <div class="ea-card">
                    <div class="ea-card-body">
                        <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">
                            Средняя цена за кв. м
                        </div>
                        <div class="mt-3 text-3xl font-semibold text-slate-900">
                            {{ number_format($averagePricePerSqm, 2, ',', ' ') }}
                        </div>
                        <div class="mt-2 text-sm text-slate-500">
                            Средний уровень цены по площади.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 grid gap-6 xl:grid-cols-3">
                <div class="ea-card">
                    <div class="ea-card-body">
                        <div class="mb-5 flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">Эффективность объектов</h3>
                                <p class="mt-1 text-sm text-slate-500">Распределение по итоговой оценке.</p>
                            </div>
                        </div>

                        <div class="grid gap-3">
                            <div class="flex items-center justify-between rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3">
                                <span class="text-sm font-medium text-emerald-700">Высокая</span>
                                <span class="text-2xl font-semibold text-emerald-900">{{ $propertyEfficiencyCounts['high'] }}</span>
                            </div>

                            <div class="flex items-center justify-between rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3">
                                <span class="text-sm font-medium text-amber-700">Средняя</span>
                                <span class="text-2xl font-semibold text-amber-900">{{ $propertyEfficiencyCounts['medium'] }}</span>
                            </div>

                            <div class="flex items-center justify-between rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3">
                                <span class="text-sm font-medium text-rose-700">Низкая</span>
                                <span class="text-2xl font-semibold text-rose-900">{{ $propertyEfficiencyCounts['low'] }}</span>
                            </div>
                        </div>

                        <div class="mt-4 text-sm text-slate-500">
                            Всего объектов в анализе: {{ $totalPropertiesForEfficiency }}
                        </div>
                    </div>
                </div>

                <div class="ea-card">
                    <div class="ea-card-body">
                        <div class="mb-5 flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">Эффективность экспозиций</h3>
                                <p class="mt-1 text-sm text-slate-500">Оценка результативности размещений.</p>
                            </div>
                        </div>

                        <div class="grid gap-3">
                            <div class="flex items-center justify-between rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3">
                                <span class="text-sm font-medium text-emerald-700">Высокая</span>
                                <span class="text-2xl font-semibold text-emerald-900">{{ $statusCounts['high'] }}</span>
                            </div>

                            <div class="flex items-center justify-between rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3">
                                <span class="text-sm font-medium text-amber-700">Средняя</span>
                                <span class="text-2xl font-semibold text-amber-900">{{ $statusCounts['medium'] }}</span>
                            </div>

                            <div class="flex items-center justify-between rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3">
                                <span class="text-sm font-medium text-rose-700">Низкая</span>
                                <span class="text-2xl font-semibold text-rose-900">{{ $statusCounts['low'] }}</span>
                            </div>
                        </div>

                        <div class="mt-4 text-sm text-slate-500">
                            Всего экспозиций в анализе: {{ $totalExposures }}
                        </div>
                    </div>
                </div>

                <div class="ea-card">
                    <div class="ea-card-body">
                        <div class="mb-5">
                            <h3 class="text-lg font-semibold text-slate-900">Быстрые действия</h3>
                            <p class="mt-1 text-sm text-slate-500">Переход к самым частым рабочим сценариям.</p>
                        </div>

                        <div class="grid gap-3">
                            <a href="{{ route('properties.index') }}"
                                class="flex items-center justify-between rounded-2xl border border-slate-200 bg-[#FAFCFC] px-4 py-3 text-sm font-medium text-slate-700 transition hover:border-slate-300 hover:bg-white">
                                <span>Перейти к объектам</span>
                                <span class="text-slate-400">→</span>
                            </a>

                            <a href="{{ route('properties.create') }}"
                                class="flex items-center justify-between rounded-2xl bg-[#0F3D3E] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#14585A]">
                                <span>Добавить объект</span>
                                <span class="text-white/70">+</span>
                            </a>

                            <a href="{{ route('exposures.index') }}"
                                class="flex items-center justify-between rounded-2xl border border-slate-200 bg-[#FAFCFC] px-4 py-3 text-sm font-medium text-slate-700 transition hover:border-slate-300 hover:bg-white">
                                <span>Перейти к экспозициям</span>
                                <span class="text-slate-400">→</span>
                            </a>

                            <a href="{{ route('exposures.create') }}"
                                class="flex items-center justify-between rounded-2xl bg-[#1F6F78] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#14585A]">
                                <span>Добавить экспозицию</span>
                                <span class="text-white/70">+</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
