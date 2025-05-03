<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentEnrollment extends Model
{
    use HasFactory;

    protected $table = 'student_enrollments';

    // Relationships
    // Studentに関連する生徒を取得 (1対1)
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
