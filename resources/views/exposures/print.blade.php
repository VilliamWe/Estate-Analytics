<x-print-layout title="Карточка экспозиции" subtitle="Экспозиция объекта: {{ $exposure->property?->title ?? 'Экспозиция' }}">
    <div class="print-card">
        <div class="print-card-body">
            <h2 class="print-section-title">{{ $exposure->property?->title ?? 'Экспозиция' }}</h2>

            <div class="meta-grid">
                <div class="meta-item">
                    <div class="meta-label">Объект</div>
                    <div class="meta-value">{{ $exposure->property?->title ?? '—' }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Канал</div>
                    <div class="meta-value">{{ $exposure->channel?->title ?? '—' }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Кто создал запись</div>
                    <div class="meta-value">{{ $exposure->creator?->name ?? '—' }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Статус</div>
                    <div class="meta-value">{{ $exposure->status }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Дата начала</div>
                    <div class="meta-value">{{ $exposure->start_date?->format('d.m.Y') ?? '—' }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Дата окончания</div>
                    <div class="meta-value">{{ $exposure->end_date?->format('d.m.Y') ?? '—' }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Цена размещения</div>
                    <div class="meta-value">{{ number_format($exposure->publication_price ?? 0, 2, ',', ' ') }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Просмотры</div>
                    <div class="meta-value">{{ $exposure->views_count }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Обращения</div>
                    <div class="meta-value">{{ $exposure->leads_count }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Длительность, дней</div>
                    <div class="meta-value">{{ $exposure->duration_days }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Просмотры в день</div>
                    <div class="meta-value">{{ number_format($exposure->views_per_day, 2, ',', ' ') }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Обращения в день</div>
                    <div class="meta-value">{{ number_format($exposure->leads_per_day, 2, ',', ' ') }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Отклонение цены, %</div>
                    <div class="meta-value">{{ number_format($exposure->price_deviation_percent, 2, ',', ' ') }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Эффективность</div>
                    <div class="meta-value">{{ ucfirst($exposure->efficiency_level) }}</div>
                </div>
            </div>

            <div class="print-block">
                <h3 class="print-section-title">Ссылка на объявление</h3>
                <div class="meta-item">
                    <div class="meta-value" style="margin-top: 0; font-weight: 400; word-break: break-word;">
                        {{ $exposure->source_url ?: 'Ссылка не указана.' }}
                    </div>
                </div>
            </div>

            <div class="print-block">
                <h3 class="print-section-title">Комментарий</h3>
                <div class="meta-item">
                    <div class="meta-value" style="margin-top: 0; font-weight: 400;">
                        {{ $exposure->comment ?: 'Комментарий не заполнен.' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-print-layout>
