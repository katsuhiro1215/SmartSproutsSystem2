<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminEnrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'enrollment_date',
        'start_date',
        'is_notified',
        'suspension_start_date',
        'suspension_end_date',
        'suspension_reason',
        'withdrawal_date',
        'withdrawal_reason',
    ];
    
    // Relationships
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
