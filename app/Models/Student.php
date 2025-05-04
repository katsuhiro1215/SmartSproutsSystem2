<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'students';

    protected $fillable = [
        'lastname',
        'firstname',
        'lastname_kana',
        'firstname_kana',
        'birth',
        'gender',
        'blood',
    ];

    // Relationships
    // Userに関連する生徒を取得 (多対多)
    public function users()
    {
        return $this->belongsToMany(User::class, 'student_user', 'student_id', 'user_id');
    }

    // Storeに関連する生徒を取得 (多対多)
    public function stores()
    {
        return $this->belongsToMany(Store::class, 'store_student', 'student_id', 'store_id');
    }

    // StudentEnrollmentに関連する生徒を取得 (1対1)
    public function studentEnrollment()
    {
        return $this->hasOne(StudentEnrollment::class);
    }

    // MembershipOptionに関連する生徒を取得 (1対多)
    public function membershipOption()
    {
        return $this->belongsTo(MembershipOption::class);
    }

    //Scope
    // 全生徒を取得するスコープ
    public function scopeAllStudents(Builder $query)
    {
        return $query;
    }
    // 削除されていない生徒を取得するスコープ
    public function scopeWithoutTrashed(Builder $query)
    {
        return $query->whereNull('deleted_at');
    }
    // 削除済み生徒を取得するスコープ
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
                        $q->where('students.lastname', 'like', '%' . $word . '%')
                            ->orWhere('students.firstname', 'like', '%' . $word . '%')
                            ->orWhere('students.lastname_kana', 'like', '%' . $word . '%')
                            ->orWhere('students.firstname_kana', 'like', '%' . $word . '%');
                    });
                }
            });
        }
        return $query; // すべてのレコードを返すために、$queryを返します
    }
}
