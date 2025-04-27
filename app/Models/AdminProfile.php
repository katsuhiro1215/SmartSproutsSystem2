<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminProfile extends Model
{
    use HasFactory;

    protected $table = 'admin_profiles';

    protected $fillable = [
        'admin_id',
        'lastname',
        'firstname',
        'lastname_kana',
        'firstname_kana',
        'admin_photo_path',
        'birth',
        'gender',
        'mobile_number',
        'admin_no',
        'serial_no',
        'website',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'line',
    ];

    // Relationships
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
