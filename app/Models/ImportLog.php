<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'import_type',
        'file_name',
        'imported_rows',
        'failed_rows',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
