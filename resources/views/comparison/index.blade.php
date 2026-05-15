<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="ea-section-title">Сравнение объектов</h2>
            <p class="mt-1 text-sm text-slate-500">
                Сопоставление ключевых характеристик нескольких объектов в одной таблице.
            </p>
        </div>
    </x-slot>

    <div class="ea-page">
        <div class="ea-container">
            @if (session('error'))
                <div class="ea-alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-6 overflow-hidden rounded-[28px] border border-slate-200 bg-[linear-gradient(135deg,#0F3D3E_0%,#14585A_58%,#1F6F78_100%)] p-6 text-white shadow-[0_24px_60px_rgba(15,61,62,0.18)] sm:p-8">
                <div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr] lg:items-end">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-[0.28em] text-white/60">
                            Comparison
                        </div>
                        <h1 class="mt-4 text-3xl font-semibold leading-tight text-white sm:text-4xl">
                            Сравнение объектов по ключевым характеристикам
                        </h1>
                        <p class="mt-4 max-w-2xl text-sm leading-7 text-white/80">
                            Быстро сопоставляйте параметры, метрики экспозиций и итоговую эффективность.
                        </p>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                            <div class="text-xs uppercase tracking-[0.2em] text-white/60">Фокус</div>
                            <div class="mt-2 text-lg font-semibold">Параметры и цены</div>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                            <div class="text-xs uppercase tracking-[0.2em] text-white/60">Результат</div>
                            <div class="mt-2 text-lg font-semibold">Сводная таблица</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ea-card mb-6">
                <div class="ea-card-body">
                    <div class="mb-5">
                        <h3 class="text-lg font-semibold text-slate-900">Выбор объектов</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Выберите от 2 до 5 объектов для сравнительного анализа.
                        </p>
                    </div>

                    <form method="GET" action="{{ route('comparison.index') }}" class="space-y-4">
                        <div>
                            <label class="ea-label">Объекты для сравнения</label>
                            <div class="grid gap-3 md:grid-cols-2 xl:grid-cols-3">
                                @foreach ($properties as $property)
                                    <label class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-[#FAFCFC] px-4 py-3 transition hover:border-slate-300 hover:bg-white">
                                        <input
                                            type="checkbox"
                                            name="properties[]"
                                            value="{{ $property->id }}"
                                            @checked(in_array($property->id, $selectedIds))
                                            class="mt-1 h-4 w-4 rounded border-slate-300 text-[#0F3D3E] focus:ring-[#1F6F78]"
                                        >
                                        <span class="text-sm font-medium text-slate-700">
                                            {{ $property->title }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>

                            <p class="mt-2 text-sm text-slate-500">
                                Выберите несколько объектов для сравнения.
                            </p>
                        </div>

                        @if (!empty($comparisonError))
                            <div class="ea-alert-error !mb-0">
                                {{ $comparisonError }}
                            </div>
                        @endif

                        <div class="flex items-center gap-3">
                            <button type="submit" class="ea-btn">
                                Сравнить
                            </button>

                            <a href="{{ route('comparison.index') }}" class="ea-btn-secondary">
                                Сбросить
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            @if ($selectedProperties->count() > 0)
                <div class="ea-card">
                    <div class="ea-card-body">
                        <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">Результаты сравнения</h3>
                                <p class="mt-1 text-sm text-slate-500">
                                    Сводная таблица по параметрам, метрикам и эффективности объектов.
                                </p>
                            </div>

                            <a href="{{ route('comparison.print', ['properties' => $selectedIds]) }}" target="_blank" class="ea-btn-secondary">
                                Печать / PDF
                            </a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="ea-table">
                                <thead>
                                    <tr>
                                        <th>Параметр</th>
                                        @foreach ($selectedProperties as $property)
                                            <th>{{ $property->title }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="font-semibold text-slate-900">Тип объекта</td>
                                        @foreach ($selectedProperties as $property)
                                            <td>{{ $property->propertyType?->title }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="font-semibold text-slate-900">Район</td>
                                        @foreach ($selectedProperties as $property)
                                            <td>{{ $property->district?->title }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="font-semibold text-slate-900">Площадь</td>
                                        @foreach ($selectedProperties as $property)
                                            <td>{{ number_format($property->area, 2, ',', ' ') }} м²</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="font-semibold text-slate-900">Цена</td>
                                        @foreach ($selectedProperties as $property)
                                            <td>{{ number_format($property->price, 2, ',', ' ') }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="font-semibold text-slate-900">Цена за кв. м</td>
                                        @foreach ($selectedProperties as $property)
                                            <td>{{ number_format($property->price_per_sqm, 2, ',', ' ') }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="font-semibold text-slate-900">Статус</td>
                                        @foreach ($selectedProperties as $property)
                                            <td>{{ $property->status }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="font-semibold text-slate-900">Число экспозиций</td>
                                        @foreach ($selectedProperties as $property)
                                            <td>{{ $property->exposures->count() }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="font-semibold text-slate-900">Просмотры</td>
                                        @foreach ($selectedProperties as $property)
                                            <td>{{ $property->exposures->sum('views_count') }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="font-semibold text-slate-900">Обращения</td>
                                        @foreach ($selectedProperties as $property)
                                            <td>{{ $property->exposures->sum('leads_count') }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="font-semibold text-slate-900">Эффективность</td>
                                        @foreach ($selectedProperties as $property)
                                            <td>{{ ucfirst($property->efficiency_level) }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="font-semibold text-slate-900">Ответственный</td>
                                        @foreach ($selectedProperties as $property)
                                            <td>{{ $property->responsibleUser?->name }}</td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
