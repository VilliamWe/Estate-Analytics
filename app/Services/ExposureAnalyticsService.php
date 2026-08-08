<?php

namespace App\Services;

use App\Models\Exposure;

class ExposureAnalyticsService
{
    public function buildChannelInsight(Exposure $exposure): array
    {
        $benchmarkQuery = Exposure::query()
            ->whereKeyNot($exposure->id)
            ->where('channel_id', $exposure->channel_id)
            ->whereHas('property', function ($query) use ($exposure) {
                $query->where('property_type_id', $exposure->property?->property_type_id)
                    ->where('district_id', $exposure->property?->district_id);
            });

        $benchmarks = (clone $benchmarkQuery)->get();
        $benchmarkCount = $benchmarks->count();
        $avgViewsPerDay = round((float) ($benchmarks->avg('views_per_day') ?? 0), 2);
        $avgLeadsPerDay = round((float) ($benchmarks->avg('leads_per_day') ?? 0), 2);

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
