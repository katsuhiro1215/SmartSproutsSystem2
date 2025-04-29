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
