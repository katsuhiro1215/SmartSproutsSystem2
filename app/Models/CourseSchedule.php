<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CourseSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'course_schedules';

    protected $fillable = [
        'course_id',
        'start_date',
        'end_date',
        'day_of_week',
        'status',
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Scopes
    // 全コーススケジュールを取得するスコープ
    public function scopeAllCourseSchedules(Builder $query)
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
