<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExposureChannel extends Model
{
    protected $fillable = [
        'title',
    ];
    public function exposures()
    {
        return $this->hasMany(Exposure::class, 'channel_id');
    }
}
