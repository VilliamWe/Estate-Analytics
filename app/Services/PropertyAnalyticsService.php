<?php

namespace App\Services;

use App\Models\Property;
use Illuminate\Support\Collection;

class PropertyAnalyticsService
{
    public function findSimilarProperties(Property $property): Collection
    {
        $baseQuery = Property::with(['propertyType', 'district'])
            ->whereKeyNot($property->id)
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

    public function buildMarketInsight(Property $property, Collection $similarProperties): array
    {
        $similarQuery = Property::query()
            ->whereKeyNot($property->id)
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
