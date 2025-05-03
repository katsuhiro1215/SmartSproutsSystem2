<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\UserResetPassword as ResetPasswordNotification;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    // Relationships
    public function userAddresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_user', 'user_id', 'student_id')
            ->withTimestamps();
    }

    public function guardians()
    {
        return $this->belongsToMany(Guardian::class, 'guardian_user', 'user_id', 'guardian_id')
            ->withTimestamps();
    }

    // Scopes
    // 全ユーザーを取得するスコープ
    public function scopeAllUsers($query)
    {
        return $query;
    }
    // 削除されていないユーザーを取得するスコープ
    public function scopeWithoutTrashed($query)
    {
        return $query->whereNull('deleted_at');
    }
    // 削除済みユーザーを取得するスコープ   
    public function scopeOnlyTrashed($query)
    {
        return $query->whereNotNull('deleted_at');
    }

    // 検索キーワードで絞り込むスコープ
    public function scopeSearchKeyword($query, $keyword)
    {
        if ($keyword) {
            return $query->where(function ($q) use ($keyword) {
                $q->where('username', 'like', '%' . $keyword . '%');
            });
        }
        return $query;
    }
}
