<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'course_categories';

    protected $fillable = [
        'lesson_id',
        'type',
        'name',
        'description',
        'course_category_photo_path',
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

    // Scopes
    // 全コースカテゴリーを取得するスコープ
    public function scopeAllCourseCategories($query)
    {
        return $query;
    }
    // 削除されていないコースカテゴリーを取得するスコープ
    public function scopeWithoutTrashed($query)
    {
        return $query->whereNull('deleted_at');
    }
    // 削除済みコースカテゴリーを取得するスコープ   
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
