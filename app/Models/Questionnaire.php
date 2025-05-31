<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Questionnaire extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'questionnaires';

    protected $fillable = [
        'name',
        'main_description',
        'sub_description',
        'annotation',
        'questionnaire_photo_path',
        'status',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
    ];

    // Scopes
    // 全イベントを取得するスコープ
    public function scopeAllQuestionnaires(Builder $query)
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
}
