<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

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
}
