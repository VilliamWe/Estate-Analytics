<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exposure extends Model
{
    use HasFactory;

    public const STATUSES = [
        'Активна',
        'Завершена',
        'Снята',
        'Неэффективна',
    ];

    protected $fillable = [
        'property_id',
        'channel_id',
        'created_by',
        'start_date',
        'end_date',
        'publication_price',
        'views_count',
        'leads_count',
        'status',
        'source_url',
        'comment',
    ];

    protected $appends = [
        'duration_days',
        'views_per_day',
        'leads_per_day',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'publication_price' => 'decimal:2',
            'views_count' => 'integer',
            'leads_count' => 'integer',
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function channel(): BelongsTo
    {
        return $this->belongsTo(ExposureChannel::class, 'channel_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getPriceDeviationPercentAttribute(): float
    {
        if (! $this->property || ! $this->property->district_id || ! $this->property->property_type_id) {
            return 0;
        }

        $averagePricePerSqm = Property::query()
            ->where('district_id', $this->property->district_id)
            ->where('property_type_id', $this->property->property_type_id)
            ->avg('price_per_sqm');

        if (! $averagePricePerSqm) {
            return 0;
        }

        return round(
            (($this->property->price_per_sqm - $averagePricePerSqm) / $averagePricePerSqm) * 100,
            2
        );
    }

    public function getEfficiencyLevelAttribute(): string
    {
        $deviation = abs($this->price_deviation_percent);
        $leadsPerDay = $this->leads_per_day;

        if ($leadsPerDay >= 0.3 && $deviation <= 10) {
            return 'Высокая';
        }

        if ($leadsPerDay >= 0.1 && $deviation <= 20) {
            return 'Средняя';
        }

        return 'Низкая';
    }

    public function getDurationDaysAttribute(): int
    {
        if (! $this->start_date) {
            return 0;
        }

        $endDate = $this->end_date ?? now();
        $days = $this->start_date->diffInDays($endDate);

        return max($days, 1);
    }

    public function getViewsPerDayAttribute(): float
    {
        if ($this->duration_days <= 0) {
            return 0;
        }

        return round($this->views_count / $this->duration_days, 2);
    }

    public function getLeadsPerDayAttribute(): float
    {
        if ($this->duration_days <= 0) {
            return 0;
        }

        return round($this->leads_count / $this->duration_days, 2);
    }
}
