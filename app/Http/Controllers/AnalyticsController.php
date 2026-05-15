<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exposure;
use App\Models\Property;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $propertiesByType = Property::query()
            ->join('property_types', 'properties.property_type_id', '=', 'property_types.id')
            ->select('property_types.title', DB::raw('COUNT(properties.id) as total'))
            ->groupBy('property_types.title')
            ->orderBy('property_types.title')
            ->get();

        $propertiesByDistrict = Property::query()
            ->join('districts', 'properties.district_id', '=', 'districts.id')
            ->select('districts.title', DB::raw('COUNT(properties.id) as total'))
            ->groupBy('districts.title')
            ->orderBy('districts.title')
            ->get();

        $exposuresByChannel = Exposure::query()
            ->join('exposure_channels', 'exposures.channel_id', '=', 'exposure_channels.id')
            ->select('exposure_channels.title', DB::raw('COUNT(exposures.id) as total'))
            ->groupBy('exposure_channels.title')
            ->orderBy('exposure_channels.title')
            ->get();

        $averagePriceByDistrict = Property::query()
            ->join('districts', 'properties.district_id', '=', 'districts.id')
            ->select('districts.title', DB::raw('AVG(properties.price) as average_price'))
            ->groupBy('districts.title')
            ->orderBy('districts.title')
            ->get();

        return view('analytics.index', compact(
            'propertiesByType',
            'propertiesByDistrict',
            'exposuresByChannel',
            'averagePriceByDistrict'
        ));
    }
}
