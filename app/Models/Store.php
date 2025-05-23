<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Store extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'stores';

    protected $fillable = [
        'organization_id',
        'type',
        'name',
        'code',
        'theme_color',
        'description',
        'email',
        'store_photo_path',
        'store_logo_path',
        'postalcode',
        'prefecture',
        'city',
        'address1',
        'address2',
        'phone_number',
        'fax_number',
        'status',
        'established_date',
        'website',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'line',
    ];

    //  Relationships
    // 店舗に関連する組織を取得 (1対多)
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    // 店舗に関連する生徒を取得 (多対多)
    public function students()
    {
        return $this->belongsToMany(Student::class, 'store_student', 'store_id', 'student_id');
    }

    // 店舗に関連するレッスンを取得 (1対多)
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    // 店舗に関するスケジュールを取得 (1対多)
    public function schedules()
    {
        return $this->hasMany(StoreSchedule::class);
    }

    // Scopes
    // 全店舗を取得するスコープ
    public function scopeAllStores(Builder $query)
    {
        return $query;
    }
    // 削除されていない店舗を取得するスコープ
    public function scopeWithoutTrashed(Builder $query)
    {
        return $query->whereNull('deleted_at');
    }
    // 削除済み店舗を取得するスコープ
    public function scopeOnlyTrashed(Builder $query)
    {
        return $query->whereNotNull('deleted_at');
    }
}
