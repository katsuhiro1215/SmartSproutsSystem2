<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;

class StoreSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'store_schedules';

    protected $fillable = [
        'store_id',
        'start_date',
        'end_date',
        'day_of_week',
        'status',
        'note',
    ];

    // Relationships
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // Scopes
    // 全店舗スケジュールを取得するスコープ
    public function scopeAllStoreSchedules(Builder $query)
    {
        return $query;
    }
    // 削除されていないスケジュールを取得するスコープ
    public function scopeWithoutTrashed(Builder $query)
    {
        return $query->whereNull('deleted_at');
    }
    // 削除済みスケジュールを取得するスコープ
    public function scopeOnlyTrashed(Builder $query)
    {
        return $query->whereNotNull('deleted_at');
    }
}
