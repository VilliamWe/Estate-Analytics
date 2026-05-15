<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
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
    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function responsibleUser()
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }
    public function exposures()
    {
        return $this->hasMany(Exposure::class);
    }

}
