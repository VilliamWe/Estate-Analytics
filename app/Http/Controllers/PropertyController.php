<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Models\District;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $propertyTypes = PropertyType::orderBy('title')->get();
        $districts = District::orderBy('title')->get();
        $users = User::orderBy('name')->get();
        $statuses = Property::STATUSES;

        return view('properties.create', compact('propertyTypes', 'districts', 'users', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyRequest $request)
    {
        $validated = $request->validated();

        $validated['price_per_sqm'] = $validated['area'] > 0
            ? round($validated['price'] / $validated['area'], 2)
            : 0;

        $property = Property::create($validated);

        return redirect()
            ->route('properties.show', $property)
            ->with('success', 'Объект успешно создан.');
    }

    /**
     * Display the specified resource.
     */
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

        $similarProperties = $this->findSimilarProperties($property);
        $marketInsight = $this->buildMarketInsight($property, $similarProperties);

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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        $propertyTypes = PropertyType::orderBy('title')->get();
        $districts = District::orderBy('title')->get();
        $users = User::orderBy('name')->get();
        $statuses = Property::STATUSES;

        return view('properties.edit', compact('property', 'propertyTypes', 'districts', 'users', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $validated = $request->validated();

        $validated['price_per_sqm'] = $validated['area'] > 0
            ? round($validated['price'] / $validated['area'], 2)
            : 0;

        $property->update($validated);

        return redirect()
            ->route('properties.show', $property)
            ->with('success', 'Объект успешно обновлён.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        $property->delete();

        return redirect()
            ->route('properties.index')
            ->with('success', 'Объект удалён.');
    }

    private function findSimilarProperties(Property $property)
    {
        $baseQuery = Property::with(['propertyType', 'district'])
            ->where('id', '!=', $property->id)
            ->where('property_type_id', $property->property_type_id);

        $sameDistrict = (clone $baseQuery)
            ->where('district_id', $property->district_id)
            ->get();

        $similarProperties = $sameDistrict->isNotEmpty()
            ? $sameDistrict
            : $baseQuery->get();

        return $similarProperties
            ->sortBy(function (Property $candidate) use ($property) {
                $areaDelta = abs((float) $candidate->area - (float) $property->area);
                $priceDelta = abs((float) $candidate->price_per_sqm - (float) $property->price_per_sqm);

                return ($areaDelta * 0.35) + ($priceDelta * 0.65);
            })
            ->take(4)
            ->values();
    }

    private function buildMarketInsight(Property $property, $similarProperties): array
    {
        $similarQuery = Property::query()
            ->where('id', '!=', $property->id)
            ->where('property_type_id', $property->property_type_id)
            ->where('district_id', $property->district_id);

        $similarCount = (clone $similarQuery)->count();
        $avgPricePerSqm = (float) ((clone $similarQuery)->avg('price_per_sqm') ?? 0);

        $priceDeltaPercent = $avgPricePerSqm > 0
            ? round((($property->price_per_sqm - $avgPricePerSqm) / $avgPricePerSqm) * 100, 2)
            : 0.0;

        $marketPosition = 'Недостаточно данных';
        $marketMessage = 'В этой категории пока недостаточно объектов для устойчивого сравнения.';
        $outlookLabel = 'Нейтральная';
        $outlookMessage = 'Рекомендуется накопить больше экспозиций и рыночных данных.';

        if ($similarCount > 0 && $avgPricePerSqm > 0) {
            if ($priceDeltaPercent <= -10) {
                $marketPosition = 'Ниже рынка';
                $marketMessage = 'Ставка за квадратный метр ниже средней по аналогам. Это может повысить интерес к объекту.';
                $outlookLabel = 'Высокая';
                $outlookMessage = 'Объект выглядит конкурентным по цене. Перспектива спроса выше средней.';
            } elseif ($priceDeltaPercent >= 10) {
                $marketPosition = 'Выше рынка';
                $marketMessage = 'Ставка за квадратный метр выше средней по аналогам. Стоит внимательнее оценить позиционирование.';
                $outlookLabel = 'Умеренная';
                $outlookMessage = 'Для роста интереса может потребоваться усиление экспозиции или корректировка цены.';
            } else {
                $marketPosition = 'В рынке';
                $marketMessage = 'Цена за квадратный метр находится рядом со средним уровнем по аналогичным объектам.';
                $outlookLabel = 'Стабильная';
                $outlookMessage = 'Объект выглядит сбалансированно и может конкурировать на текущем рынке без резких изменений.';
            }
        }

        return [
            'similar_count' => $similarCount,
            'avg_price_per_sqm' => $avgPricePerSqm,
            'price_delta_percent' => $priceDeltaPercent,
            'market_position' => $marketPosition,
            'market_message' => $marketMessage,
            'outlook_label' => $outlookLabel,
            'outlook_message' => $outlookMessage,
            'has_similar' => $similarProperties->isNotEmpty(),
        ];
    }
}
