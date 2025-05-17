<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;

class StoreSchedule extends Model
{
    use HasFactory;

    protected $table = 'store_schedules';

    protected $fillable = [
        'store_id',
        'business_date',
        'day_of_week',
        'start_time',
        'end_time',
        'status',
        'note',
    ];

    // Relationships
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
