<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\AdminResetPassword as ResetPasswordNotification;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'admins';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role'
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
    public function adminProfile()
    {
        return $this->hasOne(AdminProfile::class);
    }

    public function adminAddresses()
    {
        return $this->hasMany(AdminAddress::class);
    }

    public function adminEnrollment()
    {
        return $this->hasOne(AdminEnrollment::class);
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'admin_organization', 'admin_id', 'organization_id');
    }

    // Scopes
    // Owner
    public function scopeOwners(Builder $query)
    {
        return $query->whereIn('role', ['Owner']);
    }

    // Admin (管理者)
    public function scopeAdmins(Builder $query)
    {
        return $query->whereIn('role', ['SuperAdmin', 'Admin', 'SubAdmin']);
    }

    // Employee (従業員)
    public function scopeEmployees(Builder $query)
    {
        return $query->whereIn('role', ['Manager', 'Employee', 'Contract', 'PartTime']);
    }

    // その他 (外部講師など)
    public function scopeOthers(Builder $query)
    {
        return $query->whereNotIn('role', ['Owner', 'SuperAdmin', 'Admin', 'SubAdmin', 'Manager', 'Employee', 'Contract', 'PartTime']);
    }
}
