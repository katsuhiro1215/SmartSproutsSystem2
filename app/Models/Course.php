<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'courses';

    protected $fillable = [
        'lesson_id',
        'course_category_id',
        'name',
        'description',
        'course_photo_path',
        'status',
        'start_date',
        'end_date',
    ];

    //  Relationships
    // コースカテゴリーに関連するレッスンを取得 (1対多)
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    // コースに関連するコースカテゴリーを取得 (1対多)
    public function courseCategory()
    {
        return $this->belongsTo(CourseCategory::class);
    }

    // Scopes
    // 全コースを取得するスコープ
    public function scopeAllCourses($query)
    {
        return $query;
    }
    // 削除されていないコースを取得するスコープ
    public function scopeWithoutTrashed($query)
    {
        return $query->whereNull('deleted_at');
    }
    // 削除済みコースを取得するスコープ   
    public function scopeOnlyTrashed($query)
    {
        return $query->whereNotNull('deleted_at');
    }

    // 検索キーワードで絞り込むスコープ
    public function scopeSearchKeyword($query, $keyword)
    {
        if ($keyword) {
            return $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%');
            });
        }
        return $query;
    }
}
