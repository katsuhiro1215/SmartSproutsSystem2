<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;
class Guardian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'guardians';

    protected $fillable = [
        'lastname',
        'firstname',
        'lastname_kana',
        'firstname_kana',
        'relationship',
        'birth',
    ];

    // Relationships
    // Userに関連する保護者を取得 (多対多)
    public function users()
    {
        return $this->belongsToMany(User::class, 'guardian_user', 'guardian_id', 'user_id');
    }

    //Scope
    // 全保護者を取得するスコープ
    public function scopeAllGuardians(Builder $query)
    {
        return $query;
    }
    // 削除されていない保護者を取得するスコープ
    public function scopeWithoutTrashed(Builder $query)
    {
        return $query->whereNull('deleted_at');
    }
    // 削除済み保護者を取得するスコープ
    public function scopeOnlyTrashed(Builder $query)
    {
        return $query->whereNotNull('deleted_at');
    }
    // 検索キーワードで絞り込むスコープ
    public function scopeSearchKeyword($query, $keyword)
    {
        if (!is_null($keyword)) {
            // スペースを取り除く
            $spaceConvert = mb_convert_kana($keyword, 's');
            // キーワードを分割
            $keywords = preg_split('/[\s]+/', $spaceConvert, -1, PREG_SPLIT_NO_EMPTY);

            // 複数のキーワードをOR条件で適用
            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->orWhere(function ($q) use ($word) {
                        $q->where('guardians.lastname', 'like', '%' . $word . '%')
                            ->orWhere('guardians.firstname', 'like', '%' . $word . '%')
                            ->orWhere('guardians.lastname_kana', 'like', '%' . $word . '%')
                            ->orWhere('guardians.firstname_kana', 'like', '%' . $word . '%');
                    });
                }
            });
        }
        return $query; // すべてのレコードを返すために、$queryを返します
    }
}
