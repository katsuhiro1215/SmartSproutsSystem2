<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CourseSchedule extends Model
{
    use HasFactory;

    protected $table = 'course_schedules';

    protected $fillable = [
        'course_id',
        'course_date',
        'day_of_week',
        'start_time',
        'end_time',
        'status',
        'note',
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
