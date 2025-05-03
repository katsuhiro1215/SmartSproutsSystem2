<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreStudent extends Model
{
    use HasFactory;
    protected $table = 'store_student';

    protected $fillable = [
        'store_id',
        'student_id',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
