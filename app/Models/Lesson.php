<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lessons';

    protected $fillable = [
        'store_id',
        'name',
        'description',
        'lesson_photo_path',
        'status',
        'start_date',
        'end_date',
    ];

    // Relationships
    // レッスンに関連する店舗を取得 (1対多)
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // Scopes
    // 全レッスンを取得するスコープ
    public function scopeAllLessons($query)
    {
        return $query;
    }
    // 削除されていないレッスンを取得するスコープ
    public function scopeWithoutTrashed($query)
    {
        return $query->whereNull('deleted_at');
    }
    // 削除済みレッスンを取得するスコープ
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
