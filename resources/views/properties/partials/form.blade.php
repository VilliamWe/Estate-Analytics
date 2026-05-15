<div class="grid gap-6 md:grid-cols-2">
    <div>
        <label class="ea-label">Название объекта</label>
        <input type="text" name="title" value="{{ old('title', $property->title ?? '') }}" class="ea-input">
    </div>

    <div>
        <label class="ea-label">Тип объекта</label>
        <select name="property_type_id" class="ea-input">
            <option value="">Выберите тип</option>
            @foreach ($propertyTypes as $propertyType)
                <option value="{{ $propertyType->id }}" @selected(old('property_type_id', $property->property_type_id ?? '') == $propertyType->id)>
                    {{ $propertyType->title }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="ea-label">Район</label>
        <select name="district_id" class="ea-input">
            <option value="">Выберите район</option>
            @foreach ($districts as $district)
                <option value="{{ $district->id }}" @selected(old('district_id', $property->district_id ?? '') == $district->id)>
                    {{ $district->title }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="ea-label">Сегмент</label>
        <input type="text" name="segment" value="{{ old('segment', $property->segment ?? '') }}" class="ea-input">
    </div>

    <div class="md:col-span-2">
        <label class="ea-label">Адрес</label>
        <input type="text" name="address" value="{{ old('address', $property->address ?? '') }}" class="ea-input">
    </div>

    <div>
        <label class="ea-label">Площадь</label>
        <input type="number" step="0.01" min="0" name="area" value="{{ old('area', $property->area ?? '') }}"
            class="ea-input">
    </div>

    <div>
        <label class="ea-label">Цена</label>
        <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $property->price ?? '') }}"
            class="ea-input">
    </div>

    <div>
        <label class="ea-label">Статус</label>
        <select name="status" class="ea-input">
            @php
                $statuses = ['Новый', 'В работе', 'Активный', 'Приостановлен', 'Закрыт', 'Архивный'];
            @endphp

            <option value="">Выберите статус</option>

            @foreach ($statuses as $status)
                <option value="{{ $status }}" @selected(old('status', $property->status ?? '') == $status)>
                    {{ $status }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="ea-label">Ответственный сотрудник</label>
        <select name="responsible_user_id" class="ea-input">
            <option value="">Выберите сотрудника</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected(old('responsible_user_id', $property->responsible_user_id ?? '') == $user->id)>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="md:col-span-2">
        <label class="ea-label">Описание</label>
        <textarea name="description" rows="4"
            class="ea-input">{{ old('description', $property->description ?? '') }}</textarea>
    </div>
</div>