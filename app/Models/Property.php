<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    public const STATUSES = [
        'Новый',
        'В работе',
        'Активный',
        'Приостановлен',
        'Закрыт',
        'Архивный',
    ];

    protected $fillable = [
        'title',
        'property_type_id',
        'district_id',
        'segment',
        'address',
        'area',
        'price',
        'price_per_sqm',
        'status',
        'responsible_user_id',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'area' => 'decimal:2',
            'price' => 'decimal:2',
            'price_per_sqm' => 'decimal:2',
        ];
    }

    public function getEfficiencyLevelAttribute(): string
    {
        $levels = $this->exposures->pluck('efficiency_level');

        if ($levels->isEmpty()) {
            return 'Низкая';
        }

        if ($levels->contains('Высокая')) {
            return 'Высокая';
        }

        if ($levels->contains('Средняя')) {
            return 'Средняя';
        }

        return 'Низкая';
    }

    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function responsibleUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }

    public function exposures(): HasMany
    {
        return $this->hasMany(Exposure::class);
    }
}
