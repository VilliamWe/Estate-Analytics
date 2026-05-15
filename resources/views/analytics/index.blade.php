<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="ea-section-title">Аналитика</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Сводные показатели по объектам, районам, каналам и ценовым уровням.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="ea-page">
        <div class="ea-container">
            <div class="mb-6 overflow-hidden rounded-[28px] border border-slate-200 bg-[linear-gradient(135deg,#0F3D3E_0%,#14585A_58%,#1F6F78_100%)] p-6 text-white shadow-[0_24px_60px_rgba(15,61,62,0.18)] sm:p-8">
                <div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr] lg:items-end">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-[0.28em] text-white/60">
                            Analytics
                        </div>
                        <h1 class="mt-4 text-3xl font-semibold leading-tight sm:text-4xl text-white/80">
                            Аналитическая панель по структуре базы и рыночным показателям
                        </h1>
                        <p class="mt-4 max-w-2xl text-sm leading-7 text-white/80">
                            Используйте графики для оценки распределения объектов, каналов
                            размещения и средней стоимости по районам.
                        </p>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                            <div class="text-xs uppercase tracking-[0.2em] text-white/60">Отчёты</div>
                            <div class="mt-2 text-3xl font-semibold">4</div>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                            <div class="text-xs uppercase tracking-[0.2em] text-white/60">Фокус</div>
                            <div class="mt-2 text-lg font-semibold">Структура и цены</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 xl:grid-cols-2">
                <div class="ea-card">
                    <div class="ea-card-body">
                        <div class="mb-5">
                            <h3 class="text-lg font-semibold text-slate-900">Объекты по типам</h3>
                            <p class="mt-1 text-sm text-slate-500">
                                Показывает распределение объектов по категориям недвижимости.
                            </p>
                        </div>
                        <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] p-4">
                            <canvas id="propertiesByTypeChart" height="140"></canvas>
                        </div>
                    </div>
                </div>

                <div class="ea-card">
                    <div class="ea-card-body">
                        <div class="mb-5">
                            <h3 class="text-lg font-semibold text-slate-900">Объекты по районам</h3>
                            <p class="mt-1 text-sm text-slate-500">
                                Географическое распределение объектов в базе данных.
                            </p>
                        </div>
                        <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] p-4">
                            <canvas id="propertiesByDistrictChart" height="140"></canvas>
                        </div>
                    </div>
                </div>

                <div class="ea-card">
                    <div class="ea-card-body">
                        <div class="mb-5">
                            <h3 class="text-lg font-semibold text-slate-900">Экспозиции по каналам</h3>
                            <p class="mt-1 text-sm text-slate-500">
                                Помогает оценить распределение размещений по каналам продвижения.
                            </p>
                        </div>
                        <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] p-4">
                            <canvas id="exposuresByChannelChart" height="140"></canvas>
                        </div>
                    </div>
                </div>

                <div class="ea-card">
                    <div class="ea-card-body">
                        <div class="mb-5">
                            <h3 class="text-lg font-semibold text-slate-900">Средняя цена по районам</h3>
                            <p class="mt-1 text-sm text-slate-500">
                                Сравнение ценового уровня между различными районами.
                            </p>
                        </div>
                        <div class="rounded-2xl border border-slate-100 bg-[#FAFCFC] p-4">
                            <canvas id="averagePriceByDistrictChart" height="140"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartCommonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: '#475569',
                        font: {
                            size: 12,
                        },
                    },
                },
            },
            scales: {
                x: {
                    ticks: {
                        color: '#64748B',
                    },
                    grid: {
                        display: false,
                    },
                },
                y: {
                    ticks: {
                        color: '#64748B',
                    },
                    grid: {
                        color: 'rgba(148, 163, 184, 0.15)',
                    },
                },
            },
        };

        const propertiesByTypeLabels = @json($propertiesByType->pluck('title'));
        const propertiesByTypeData = @json($propertiesByType->pluck('total'));

        const propertiesByDistrictLabels = @json($propertiesByDistrict->pluck('title'));
        const propertiesByDistrictData = @json($propertiesByDistrict->pluck('total'));

        const exposuresByChannelLabels = @json($exposuresByChannel->pluck('title'));
        const exposuresByChannelData = @json($exposuresByChannel->pluck('total'));

        const averagePriceByDistrictLabels = @json($averagePriceByDistrict->pluck('title'));
        const averagePriceByDistrictData = @json($averagePriceByDistrict->pluck('average_price'));

        new Chart(document.getElementById('propertiesByTypeChart'), {
            type: 'bar',
            data: {
                labels: propertiesByTypeLabels,
                datasets: [{
                    label: 'Количество объектов',
                    data: propertiesByTypeData,
                    backgroundColor: '#0F3D3E',
                    borderRadius: 10,
                    borderSkipped: false,
                }]
            },
            options: {
                ...chartCommonOptions,
                plugins: {
                    ...chartCommonOptions.plugins,
                    legend: { display: false },
                },
            }
        });

        new Chart(document.getElementById('propertiesByDistrictChart'), {
            type: 'bar',
            data: {
                labels: propertiesByDistrictLabels,
                datasets: [{
                    label: 'Количество объектов',
                    data: propertiesByDistrictData,
                    backgroundColor: '#1F6F78',
                    borderRadius: 10,
                    borderSkipped: false,
                }]
            },
            options: {
                ...chartCommonOptions,
                plugins: {
                    ...chartCommonOptions.plugins,
                    legend: { display: false },
                },
            }
        });

        new Chart(document.getElementById('exposuresByChannelChart'), {
            type: 'doughnut',
            data: {
                labels: exposuresByChannelLabels,
                datasets: [{
                    data: exposuresByChannelData,
                    backgroundColor: ['#0F3D3E', '#1F6F78', '#2E8B86', '#C7771A', '#D95F5F'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#475569',
                            boxWidth: 12,
                            usePointStyle: true,
                            pointStyle: 'circle',
                        },
                    },
                },
            }
        });

        new Chart(document.getElementById('averagePriceByDistrictChart'), {
            type: 'line',
            data: {
                labels: averagePriceByDistrictLabels,
                datasets: [{
                    label: 'Средняя цена',
                    data: averagePriceByDistrictData,
                    borderColor: '#0F3D3E',
                    backgroundColor: 'rgba(31, 111, 120, 0.12)',
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#0F3D3E',
                    pointBorderColor: '#0F3D3E',
                    pointRadius: 4,
                }]
            },
            options: chartCommonOptions
        });
    </script>
</x-app-layout>
