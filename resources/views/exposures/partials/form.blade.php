<div class="grid gap-6 md:grid-cols-2">
    <div>
        <label class="ea-label">Объект</label>
        <select name="property_id" class="ea-input">
            <option value="">Выберите объект</option>
            @foreach ($properties as $property)
                <option value="{{ $property->id }}" @selected(old('property_id', $exposure->property_id ?? '') == $property->id)>
                    {{ $property->title }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="ea-label">Канал размещения</label>
        <select name="channel_id" class="ea-input">
            <option value="">Выберите канал</option>
            @foreach ($channels as $channel)
                <option value="{{ $channel->id }}" @selected(old('channel_id', $exposure->channel_id ?? '') == $channel->id)>
                    {{ $channel->title }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="ea-label">Дата начала</label>
        <input
            type="date"
            name="start_date"
            value="{{ old('start_date', isset($exposure) && $exposure->start_date ? $exposure->start_date->format('Y-m-d') : '') }}"
            class="ea-input"
        >
    </div>

    <div>
        <label class="ea-label">Дата окончания</label>
        <input
            type="date"
            name="end_date"
            value="{{ old('end_date', isset($exposure) && $exposure->end_date ? $exposure->end_date->format('Y-m-d') : '') }}"
            class="ea-input"
        >
    </div>

    <div>
        <label class="ea-label">Цена размещения</label>
        <input
            type="number"
            step="0.01"
            min="0"
            name="publication_price"
            value="{{ old('publication_price', $exposure->publication_price ?? '') }}"
            class="ea-input"
        >
    </div>

    <div>
        <label class="ea-label">Статус</label>
        <select name="status" class="ea-input">
            <option value="">Выберите статус</option>
            @foreach ($statuses as $status)
                <option value="{{ $status }}" @selected(old('status', $exposure->status ?? '') == $status)>
                    {{ $status }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="ea-label">Просмотры</label>
        <input
            type="number"
            min="0"
            name="views_count"
            value="{{ old('views_count', $exposure->views_count ?? 0) }}"
            class="ea-input"
        >
    </div>

    <div>
        <label class="ea-label">Обращения</label>
        <input
            type="number"
            min="0"
            name="leads_count"
            value="{{ old('leads_count', $exposure->leads_count ?? 0) }}"
            class="ea-input"
        >
    </div>

    <div class="md:col-span-2">
        <label class="ea-label">Ссылка на объявление</label>
        <input
            type="url"
            name="source_url"
            value="{{ old('source_url', $exposure->source_url ?? '') }}"
            class="ea-input"
        >
    </div>

    <div class="md:col-span-2">
        <label class="ea-label">Комментарий</label>
        <textarea name="comment" rows="4" class="ea-input">{{ old('comment', $exposure->comment ?? '') }}</textarea>
    </div>
</div>
