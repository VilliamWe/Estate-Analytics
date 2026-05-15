<x-print-layout title="Карточка объекта" subtitle="Объект недвижимости: {{ $property->title }}">
    <div class="print-card">
        <div class="print-card-body">
            <h2 class="print-section-title">{{ $property->title }}</h2>

            <div class="meta-grid">
                <div class="meta-item">
                    <div class="meta-label">Тип объекта</div>
                    <div class="meta-value">{{ $property->propertyType?->title ?? '—' }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Район</div>
                    <div class="meta-value">{{ $property->district?->title ?? '—' }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Сегмент</div>
                    <div class="meta-value">{{ $property->segment ?: '—' }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Статус</div>
                    <div class="meta-value">{{ $property->status }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Адрес</div>
                    <div class="meta-value">{{ $property->address }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Ответственный</div>
                    <div class="meta-value">{{ $property->responsibleUser?->name ?? '—' }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Площадь</div>
                    <div class="meta-value">{{ number_format($property->area, 2, ',', ' ') }} м²</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Цена</div>
                    <div class="meta-value">{{ number_format($property->price, 2, ',', ' ') }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Цена за кв. м</div>
                    <div class="meta-value">{{ number_format($property->price_per_sqm, 2, ',', ' ') }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Активные экспозиции</div>
                    <div class="meta-value">{{ $activeExposuresCount }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Общие просмотры</div>
                    <div class="meta-value">{{ $totalViews }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Общие обращения</div>
                    <div class="meta-value">{{ $totalLeads }}</div>
                </div>
            </div>

            <div class="print-block">
                <h3 class="print-section-title">Описание</h3>
                <div class="meta-item">
                    <div class="meta-value" style="margin-top: 0; font-weight: 400;">
                        {{ $property->description ?: 'Описание не заполнено.' }}
                    </div>
                </div>
            </div>

            <div class="print-block">
                <h3 class="print-section-title">Экспозиции объекта</h3>
                <table class="print-table">
                    <thead>
                        <tr>
                            <th>Канал</th>
                            <th>Начало</th>
                            <th>Окончание</th>
                            <th>Просмотры</th>
                            <th>Обращения</th>
                            <th>Статус</th>
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">Для этого объекта пока нет экспозиций.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-print-layout>
