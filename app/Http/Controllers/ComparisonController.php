<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ComparisonController extends Controller
{
    public function index(Request $request)
    {
        $properties = Property::query()
            ->select('id', 'title')
            ->orderBy('title')
            ->get();

        [$selectedIds, $selectedProperties, $comparisonError] = $this->resolveComparisonData($request);

        return view('comparison.index', compact(
            'properties',
            'selectedIds',
            'selectedProperties',
            'comparisonError'
        ));
    }

    public function print(Request $request)
    {
        [$selectedIds, $selectedProperties, $comparisonError] = $this->resolveComparisonData($request);

        if ($comparisonError || $selectedProperties->isEmpty()) {
            return redirect()
                ->route('comparison.index', ['properties' => $selectedIds])
                ->with('error', $comparisonError ?: 'Для печати нужно выбрать объекты для сравнения.');
        }

        return view('comparison.print', compact(
            'selectedIds',
            'selectedProperties'
        ));
    }

    private function resolveComparisonData(Request $request): array
    {
        $selectedIds = collect($request->input('properties', []))
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();

        $selectedProperties = collect();
        $comparisonError = null;

        if (! empty($selectedIds) && count($selectedIds) < 2) {
            $comparisonError = 'Для сравнения нужно выбрать минимум 2 объекта.';
        } elseif (count($selectedIds) > 5) {
            $comparisonError = 'Можно выбрать не более 5 объектов.';
        } elseif (! empty($selectedIds)) {
            $selectedProperties = Property::with([
                'propertyType',
                'district',
                'responsibleUser',
                'exposures.channel',
            ])
                ->whereIn('id', $selectedIds)
                ->get();
        }

        return [$selectedIds, $selectedProperties, $comparisonError];
    }
}
