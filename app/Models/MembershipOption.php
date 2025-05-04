<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
