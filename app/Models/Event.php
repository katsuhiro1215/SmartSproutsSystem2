<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'events';

    protected $fillable = [
        'name',
        'description',
        'event_photo_path',
        'postalcode',
        'prefecture',
        'city',
        'address1',
        'address2',
        'phone_number',
        'status',
        'application_start_date',
        'application_start_time',
        'application_end_date',
        'application_end_time',
    ];

    // Relationships
    // イベントに関連するイベントスケジュールを取得 (1対多)
    public function eventSchedules()
    {
        return $this->hasMany(EventSchedule::class);
    }

    // Scopes
    // 全イベントを取得するスコープ
    public function scopeAllEvents(Builder $query)
    {
        return $query;
    }
    // 削除されていないイベントを取得するスコープ
    public function scopeWithoutTrashed(Builder $query)
    {
        return $query->whereNull('deleted_at');
    }
    // 削除済みイベントを取得するスコープ
    public function scopeOnlyTrashed(Builder $query)
    {
        return $query->whereNotNull('deleted_at');
    }
    // 削除されていないイベント、かつ開催期間を終了したイベントを取得するスコープ
    public function scopeEnded(Builder $query)
    {
        return $query->whereNull('deleted_at')
                     ->where('event_end_date', '<', now()->toDateString())
                     ->orWhere(function ($query) {
                         $query->where('event_end_date', now()->toDateString())
                               ->where('event_end_time', '<', now()->toTimeString());
                     });
    }
}
