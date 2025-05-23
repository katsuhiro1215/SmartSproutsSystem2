<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;

class MembershipOption extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'membership_options';

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    // Relationships
    // メンバーシップオプションに関連する生徒を取得 (1対多)
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    // Scopes
    // 全メンバーシップオプションを取得するスコープ
    public function scopeAllMembershipOptions(Builder $query)
    {
        return $query;
    }
    // 削除されていないメンバーシップオプションを取得するスコープ
    public function scopeWithoutTrashed(Builder $query)
    {
        return $query->whereNull('deleted_at');
    }
    // 削除済みメンバーシップオプションを取得するスコープ
    public function scopeOnlyTrashed(Builder $query)
    {
        return $query->whereNotNull('deleted_at');
    }
}
