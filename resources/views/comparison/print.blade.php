<x-print-layout title="Сравнение объектов" subtitle="Сравнительная таблица объектов недвижимости">
    <div class="print-card">
        <div class="print-card-body">
            <h2 class="print-section-title">Сравнительная таблица</h2>

            <table class="print-table">
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
                        <td><strong>Тип объекта</strong></td>
                        @foreach ($selectedProperties as $property)
                            <td>{{ $property->propertyType?->title }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Район</strong></td>
                        @foreach ($selectedProperties as $property)
                            <td>{{ $property->district?->title }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Площадь</strong></td>
                        @foreach ($selectedProperties as $property)
                            <td>{{ number_format($property->area, 2, ',', ' ') }} м²</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Цена</strong></td>
                        @foreach ($selectedProperties as $property)
                            <td>{{ number_format($property->price, 2, ',', ' ') }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Цена за кв. м</strong></td>
                        @foreach ($selectedProperties as $property)
                            <td>{{ number_format($property->price_per_sqm, 2, ',', ' ') }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Статус</strong></td>
                        @foreach ($selectedProperties as $property)
                            <td>{{ $property->status }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Число экспозиций</strong></td>
                        @foreach ($selectedProperties as $property)
                            <td>{{ $property->exposures->count() }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Просмотры</strong></td>
                        @foreach ($selectedProperties as $property)
                            <td>{{ $property->exposures->sum('views_count') }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Обращения</strong></td>
                        @foreach ($selectedProperties as $property)
                            <td>{{ $property->exposures->sum('leads_count') }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Эффективность</strong></td>
                        @foreach ($selectedProperties as $property)
                            <td>{{ ucfirst($property->efficiency_level) }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Ответственный</strong></td>
                        @foreach ($selectedProperties as $property)
                            <td>{{ $property->responsibleUser?->name }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>

            <div class="print-note">
                Дата формирования: {{ now()->format('d.m.Y H:i') }}
            </div>
        </div>
    </div>
</x-print-layout>
