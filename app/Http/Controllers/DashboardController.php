<?php

namespace App\Http\Controllers;
use App\Models\Exposure;
use App\Models\Property;
class DashboardController extends Controller
{
    public function index()
    {
        $totalProperties = Property::count();

        $activeProperties = Property::where('status', 'Активный')->count();

        $averagePrice = Property::avg('price') ?? 0;

        $averagePricePerSqm = Property::avg('price_per_sqm') ?? 0;

        $properties = Property::with([
            'exposures:id,property_id,start_date,end_date,views_count,leads_count'
        ])->get(['id']);

        $propertyEfficiencyCounts = [
            'high' => $properties->where('efficiency_level', 'Высокая')->count(),
            'medium' => $properties->where('efficiency_level', 'Средняя')->count(),
            'low' => $properties->where('efficiency_level', 'Низкая')->count(),
        ];

        $totalPropertiesForEfficiency = $properties->count();


        $exposures = Exposure::with([
            'property:id,district_id,property_type_id,price_per_sqm'
        ])->get([
                    'id',
                    'property_id',
                    'start_date',
                    'end_date',
                    'views_count',
                    'leads_count',
                ]);

        $statusCounts = [
            'high' => $exposures->where('efficiency_level', 'Высокая')->count(),
            'medium' => $exposures->where('efficiency_level', 'Средняя')->count(),
            'low' => $exposures->where('efficiency_level', 'Низкая')->count(),
        ];


        $propertyEfficiencyCounts = [
            'high' => $properties->where('efficiency_level', 'Высокая')->count(),
            'medium' => $properties->where('efficiency_level', 'Средняя')->count(),
            'low' => $properties->where('efficiency_level', 'Низкая')->count(),
        ];

        $totalPropertiesForEfficiency = $properties->count();


        $exposures = Exposure::with([
            'property:id,district_id,property_type_id,price_per_sqm'
        ])->get([
                    'id',
                    'property_id',
                    'start_date',
                    'end_date',
                    'views_count',
                    'leads_count',
                ]);

        $statusCounts = [
            'high' => $exposures->where('efficiency_level', 'Высокая')->count(),
            'medium' => $exposures->where('efficiency_level', 'Средняя')->count(),
            'low' => $exposures->where('efficiency_level', 'Низкая')->count(),
        ];

        $totalExposures = $exposures->count();

        return view('dashboard', compact(
            'totalProperties',
            'activeProperties',
            'averagePrice',
            'averagePricePerSqm',
            'statusCounts',
            'totalExposures',
            'propertyEfficiencyCounts',
            'totalPropertiesForEfficiency'
        ));
    }
}
