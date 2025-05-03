<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    use HasFactory;

    protected $table = 'guardians';

    // Relationships
    // Userに関連する保護者を取得 (多対多)
    public function users()
    {
        return $this->belongsToMany(User::class, 'guardian_user', 'guardian_id', 'user_id');
    }
}
