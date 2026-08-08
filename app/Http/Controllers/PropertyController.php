<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Models\District;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\User;
use App\Services\PropertyAnalyticsService;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function __construct(
        private readonly PropertyAnalyticsService $analyticsService
    ) {
    }

    public function index(Request $request)
    {
        $query = Property::with(['propertyType', 'district', 'responsibleUser']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('property_type_id')) {
            $query->where('property_type_id', $request->property_type_id);
        }

        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $properties = $query->latest()->paginate(10)->withQueryString();
        $propertyTypes = PropertyType::orderBy('title')->get();
        $districts = District::orderBy('title')->get();
        $statuses = Property::STATUSES;

        return view('properties.index', compact(
            'properties',
            'propertyTypes',
            'districts',
            'statuses'
        ));
    }

    public function create()
    {
        $propertyTypes = PropertyType::orderBy('title')->get();
        $districts = District::orderBy('title')->get();
        $users = User::orderBy('name')->get();
        $statuses = Property::STATUSES;

        return view('properties.create', compact('propertyTypes', 'districts', 'users', 'statuses'));
    }

    public function store(StorePropertyRequest $request)
    {
        $validated = $request->validated();
        $validated['price_per_sqm'] = $this->calculatePricePerSqm($validated);

        $property = Property::create($validated);

        return redirect()
            ->route('properties.show', $property)
            ->with('success', 'Объект успешно создан.');
    }

    public function show(Property $property)
    {
        $property->load([
            'propertyType',
            'district',
            'responsibleUser',
            'exposures.channel',
        ]);

        $activeExposuresCount = $property->exposures
            ->where('status', 'Активна')
            ->count();
        $totalViews = $property->exposures->sum('views_count');
        $totalLeads = $property->exposures->sum('leads_count');

        $similarProperties = $this->analyticsService->findSimilarProperties($property);
        $marketInsight = $this->analyticsService->buildMarketInsight($property, $similarProperties);

        return view('properties.show', compact(
            'property',
            'activeExposuresCount',
            'totalViews',
            'totalLeads',
            'similarProperties',
            'marketInsight'
        ));
    }

    public function print(Property $property)
    {
        $property->load([
            'propertyType',
            'district',
            'responsibleUser',
            'exposures.channel',
        ]);

        $activeExposuresCount = $property->exposures
            ->where('status', 'Активна')
            ->count();
        $totalViews = $property->exposures->sum('views_count');
        $totalLeads = $property->exposures->sum('leads_count');

        return view('properties.print', compact(
            'property',
            'activeExposuresCount',
            'totalViews',
            'totalLeads'
        ));
    }

    public function edit(Property $property)
    {
        $propertyTypes = PropertyType::orderBy('title')->get();
        $districts = District::orderBy('title')->get();
        $users = User::orderBy('name')->get();
        $statuses = Property::STATUSES;

        return view('properties.edit', compact('property', 'propertyTypes', 'districts', 'users', 'statuses'));
    }

    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $validated = $request->validated();
        $validated['price_per_sqm'] = $this->calculatePricePerSqm($validated);

        $property->update($validated);

        return redirect()
            ->route('properties.show', $property)
            ->with('success', 'Объект успешно обновлён.');
    }

    public function destroy(Property $property)
    {
        $property->delete();

        return redirect()
            ->route('properties.index')
            ->with('success', 'Объект удалён.');
    }

    private function calculatePricePerSqm(array $data): float
    {
        return (float) ($data['area'] > 0
            ? round($data['price'] / $data['area'], 2)
            : 0);
    }
}
