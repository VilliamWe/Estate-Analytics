<?php

namespace App\Http\Controllers;

use App\Models\Exposure;
use App\Models\ExposureChannel;
use App\Models\Property;
use Illuminate\Http\Request;

class ExposureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $statuses = ['Активна', 'Завершена', 'Снята', 'Неэффективна'];

        $filters = $request->only([
            'property_id',
            'channel_id',
            'status',
            'start_date_from',
            'start_date_to',
        ]);

        $exposures = Exposure::query()
            ->with(['property', 'channel', 'creator'])
            ->when($request->filled('property_id'), function ($query) use ($request) {
                $query->where('property_id', $request->integer('property_id'));
            })
            ->when($request->filled('channel_id'), function ($query) use ($request) {
                $query->where('channel_id', $request->integer('channel_id'));
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->string('status'));
            })
            ->when($request->filled('start_date_from'), function ($query) use ($request) {
                $query->whereDate('start_date', '>=', $request->date('start_date_from')->format('Y-m-d'));
            })
            ->when($request->filled('start_date_to'), function ($query) use ($request) {
                $query->whereDate('start_date', '<=', $request->date('start_date_to')->format('Y-m-d'));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $properties = Property::query()
            ->select('id', 'title')
            ->orderBy('title')
            ->get();

        $channels = ExposureChannel::query()
            ->select('id', 'title')
            ->orderBy('title')
            ->get();

        return view('exposures.index', compact(
            'exposures',
            'properties',
            'channels',
            'statuses',
            'filters'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $properties = Property::orderBy('title')->get();
        $channels = ExposureChannel::orderBy('title')->get();
        $statuses = ['Активна', 'Завершена', 'Снята', 'Неэффективна'];

        return view('exposures.create', compact('properties', 'channels', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => ['required', 'exists:properties,id'],
            'channel_id' => ['required', 'exists:exposure_channels,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'publication_price' => ['nullable', 'numeric', 'min:0'],
            'views_count' => ['required', 'integer', 'min:0'],
            'leads_count' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'string', 'max:255'],
            'source_url' => ['nullable', 'url'],
            'comment' => ['nullable', 'string', 'max:200'],
        ]);

        $validated['created_by'] = auth()->id();

        $exposure = Exposure::create($validated);

        return redirect()
            ->route('exposures.show', $exposure)
            ->with('success', 'Экспозиция успешно создана.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Exposure $exposure)
    {
        $exposure->load([
            'property.propertyType',
            'property.district',
            'channel',
            'creator',
        ]);

        $channelInsight = $this->buildChannelInsight($exposure);

        return view('exposures.show', compact('exposure', 'channelInsight'));
    }

    public function print(Exposure $exposure)
    {
        $exposure->load(['property', 'channel', 'creator']);

        return view('exposures.print', compact('exposure'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exposure $exposure)
    {
        $properties = Property::orderBy('title')->get();
        $channels = ExposureChannel::orderBy('title')->get();
        $statuses = ['Активна', 'Завершена', 'Снята', 'Неэффективна'];

        return view('exposures.edit', compact('exposure', 'properties', 'channels', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exposure $exposure)
    {
        $validated = $request->validate([
            'property_id' => ['required', 'exists:properties,id'],
            'channel_id' => ['required', 'exists:exposure_channels,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'publication_price' => ['nullable', 'numeric', 'min:0'],
            'views_count' => ['required', 'integer', 'min:0'],
            'leads_count' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'string', 'max:255'],
            'source_url' => ['nullable', 'url'],
            'comment' => ['nullable', 'string', 'max:200'],
        ]);

        $exposure->update($validated);

        return redirect()
            ->route('exposures.show', $exposure)
            ->with('success', 'Экспозиция успешно обновлена.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exposure $exposure)
    {
        $exposure->delete();

        return redirect()
            ->route('exposures.index')
            ->with('success', 'Экспозиция удалена.');
    }

    private function buildChannelInsight(Exposure $exposure): array
    {
        $benchmarkQuery = Exposure::query()
            ->where('id', '!=', $exposure->id)
            ->where('channel_id', $exposure->channel_id)
            ->whereHas('property', function ($query) use ($exposure) {
                $query->where('property_type_id', $exposure->property?->property_type_id)
                    ->where('district_id', $exposure->property?->district_id);
            });

        $benchmarkCount = (clone $benchmarkQuery)->count();
        $avgViewsPerDay = round((float) ((clone $benchmarkQuery)->get()->avg('views_per_day') ?? 0), 2);
        $avgLeadsPerDay = round((float) ((clone $benchmarkQuery)->get()->avg('leads_per_day') ?? 0), 2);

        $viewsDelta = $avgViewsPerDay > 0
            ? round((($exposure->views_per_day - $avgViewsPerDay) / $avgViewsPerDay) * 100, 2)
            : 0.0;

        $leadsDelta = $avgLeadsPerDay > 0
            ? round((($exposure->leads_per_day - $avgLeadsPerDay) / $avgLeadsPerDay) * 100, 2)
            : 0.0;

        $channelPosition = 'Недостаточно данных';
        $channelMessage = 'Для этого канала пока мало сопоставимых размещений в базе.';
        $recommendationTitle = 'Наблюдение';
        $recommendationText = 'Продолжайте накапливать статистику, чтобы рекомендации стали точнее.';

        if ($benchmarkCount > 0) {
            if ($leadsDelta >= 15) {
                $channelPosition = 'Сильнее среднего';
                $channelMessage = 'Экспозиция привлекает обращения лучше, чем аналогичные размещения по этому каналу.';
                $recommendationTitle = 'Канал стоит усиливать';
                $recommendationText = 'Текущий канал показывает хороший отклик. Можно продлить размещение или перераспределить бюджет в его пользу.';
            } elseif ($leadsDelta <= -15) {
                $channelPosition = 'Слабее среднего';
                $channelMessage = 'Количество обращений ниже среднего уровня по похожим размещениям.';
                $recommendationTitle = 'Нужна корректировка';
                $recommendationText = 'Стоит проверить цену, описание и период размещения, либо протестировать дополнительный канал продвижения.';
            } else {
                $channelPosition = 'На уровне рынка';
                $channelMessage = 'Результативность канала близка к усреднённым значениям по аналогам.';
                $recommendationTitle = 'Стабильное размещение';
                $recommendationText = 'Экспозиция работает в ожидаемом диапазоне. Имеет смысл доработать точечно описание и оффер.';
            }
        }

        return [
            'benchmark_count' => $benchmarkCount,
            'avg_views_per_day' => $avgViewsPerDay,
            'avg_leads_per_day' => $avgLeadsPerDay,
            'views_delta_percent' => $viewsDelta,
            'leads_delta_percent' => $leadsDelta,
            'channel_position' => $channelPosition,
            'channel_message' => $channelMessage,
            'recommendation_title' => $recommendationTitle,
            'recommendation_text' => $recommendationText,
        ];
    }
}
