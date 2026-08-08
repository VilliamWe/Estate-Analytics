<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExposureRequest;
use App\Http\Requests\UpdateExposureRequest;
use App\Models\Exposure;
use App\Models\ExposureChannel;
use App\Models\Property;
use App\Services\ExposureAnalyticsService;
use Illuminate\Http\Request;

class ExposureController extends Controller
{
    public function __construct(
        private readonly ExposureAnalyticsService $analyticsService
    ) {
    }

    public function index(Request $request)
    {
        $statuses = Exposure::STATUSES;

        $filters = $request->only([
            'property_id',
            'channel_id',
            'status',
            'start_date_from',
            'start_date_to',
        ]);

        $exposures = Exposure::query()
            ->with(['property', 'channel', 'creator'])
            ->when($request->filled('property_id'), fn ($query) =>
                $query->where('property_id', $request->integer('property_id')))
            ->when($request->filled('channel_id'), fn ($query) =>
                $query->where('channel_id', $request->integer('channel_id')))
            ->when($request->filled('status'), fn ($query) =>
                $query->where('status', $request->string('status')))
            ->when($request->filled('start_date_from'), fn ($query) =>
                $query->whereDate('start_date', '>=', $request->date('start_date_from')->format('Y-m-d')))
            ->when($request->filled('start_date_to'), fn ($query) =>
                $query->whereDate('start_date', '<=', $request->date('start_date_to')->format('Y-m-d')))
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

    public function create()
    {
        $properties = Property::orderBy('title')->get();
        $channels = ExposureChannel::orderBy('title')->get();
        $statuses = Exposure::STATUSES;

        return view('exposures.create', compact('properties', 'channels', 'statuses'));
    }

    public function store(StoreExposureRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->id();

        $exposure = Exposure::create($validated);

        return redirect()
            ->route('exposures.show', $exposure)
            ->with('success', 'Экспозиция успешно создана.');
    }

    public function show(Exposure $exposure)
    {
        $exposure->load([
            'property.propertyType',
            'property.district',
            'channel',
            'creator',
        ]);

        $channelInsight = $this->analyticsService->buildChannelInsight($exposure);

        return view('exposures.show', compact('exposure', 'channelInsight'));
    }

    public function print(Exposure $exposure)
    {
        $exposure->load(['property', 'channel', 'creator']);

        return view('exposures.print', compact('exposure'));
    }

    public function edit(Exposure $exposure)
    {
        $properties = Property::orderBy('title')->get();
        $channels = ExposureChannel::orderBy('title')->get();
        $statuses = Exposure::STATUSES;

        return view('exposures.edit', compact('exposure', 'properties', 'channels', 'statuses'));
    }

    public function update(UpdateExposureRequest $request, Exposure $exposure)
    {
        $exposure->update($request->validated());

        return redirect()
            ->route('exposures.show', $exposure)
            ->with('success', 'Экспозиция успешно обновлена.');
    }

    public function destroy(Exposure $exposure)
    {
        $exposure->delete();

        return redirect()
            ->route('exposures.index')
            ->with('success', 'Экспозиция удалена.');
    }
}
