<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="ea-section-title">Объекты недвижимости</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Реестр объектов с быстрым поиском, фильтрами и переходом в карточки.
                </p>
            </div>

            <a href="{{ route('properties.create') }}" class="ea-btn">
                Добавить объект
            </a>
        </div>
    </x-slot>

    <div class="ea-page">
        <div class="ea-container">
            <div class="mb-6 overflow-hidden rounded-[28px] border border-slate-200 bg-[linear-gradient(135deg,#0F3D3E_0%,#14585A_58%,#1F6F78_100%)] p-6 text-white shadow-[0_24px_60px_rgba(15,61,62,0.18)] sm:p-8">
                <div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr] lg:items-end">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-[0.28em] text-white/60">
                            Properties
                        </div>
                        <h1 class="mt-4 text-3xl font-semibold leading-tight sm:text-4xl text-white/80">
                            Единый реестр объектов недвижимости
                        </h1>
                        <p class="mt-4 max-w-2xl text-sm leading-7 text-white/80">
                            Поиск, фильтрация и управление объектами в одной рабочей таблице.
                        </p>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                            <div class="text-xs uppercase tracking-[0.2em] text-white/60">Фокус</div>
                            <div class="mt-2 text-lg font-semibold">Каталог и фильтры</div>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                            <div class="text-xs uppercase tracking-[0.2em] text-white/60">Действие</div>
                            <div class="mt-2 text-lg font-semibold">Создание и просмотр</div>
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
                            Сузьте выборку по названию, типу, району и статусу.
                        </p>
                    </div>

                    <form method="GET" action="{{ route('properties.index') }}" class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
                        <div class="xl:col-span-2">
                            <label class="ea-label">Поиск</label>
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Название или адрес"
                                class="ea-input"
                            >
                        </div>

                        <div>
                            <label class="ea-label">Тип объекта</label>
                            <select name="property_type_id" class="ea-input">
                                <option value="">Все</option>
                                @foreach ($propertyTypes as $propertyType)
                                    <option value="{{ $propertyType->id }}" @selected(request('property_type_id') == $propertyType->id)>
                                        {{ $propertyType->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="ea-label">Район</label>
                            <select name="district_id" class="ea-input">
                                <option value="">Все</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}" @selected(request('district_id') == $district->id)>
                                        {{ $district->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="ea-label">Статус</label>
                            <select name="status" class="ea-input">
                                <option value="">Все</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}" @selected(request('status') == $status)>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center gap-3 md:col-span-2 xl:col-span-5">
                            <button type="submit" class="ea-btn">
                                Применить
                            </button>

                            <a href="{{ route('properties.index') }}" class="ea-btn-secondary">
                                Сбросить
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="ea-card">
                <div class="ea-card-body">
                    <div class="mb-5 flex items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">Список объектов</h3>
                            <p class="mt-1 text-sm text-slate-500">
                                Актуальные объекты, доступные для просмотра и редактирования.
                            </p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="ea-table">
                            <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>Тип</th>
                                    <th>Район</th>
                                    <th>Площадь</th>
                                    <th>Цена</th>
                                    <th>Статус</th>
                                    <th>Ответственный</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($properties as $property)
                                    <tr>
                                        <td class="font-semibold text-slate-900">{{ $property->title }}</td>
                                        <td>{{ $property->propertyType?->title }}</td>
                                        <td>{{ $property->district?->title }}</td>
                                        <td>{{ number_format($property->area, 2, ',', ' ') }} м²</td>
                                        <td>{{ number_format($property->price, 2, ',', ' ') }}</td>
                                        <td>{{ $property->status }}</td>
                                        <td>{{ $property->responsibleUser?->name }}</td>
                                        <td>
                                            <div class="flex items-center gap-3 whitespace-nowrap">
                                                <a href="{{ route('properties.show', $property) }}" class="ea-link">
                                                    Открыть
                                                </a>

                                                <a href="{{ route('properties.edit', $property) }}" class="ea-link-warning">
                                                    Редактировать
                                                </a>

                                                <form action="{{ route('properties.destroy', $property) }}" method="POST" onsubmit="return confirm('Удалить объект?');">
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
                                        <td colspan="8" class="py-8 text-center text-slate-500">
                                            Объекты по заданным условиям не найдены.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $properties->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
