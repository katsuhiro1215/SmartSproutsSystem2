<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminAddress extends Model
{
    use HasFactory;

    protected $table = 'admin_addresses';
    
    protected $fillable = [
        'admin_id',
        'postal_code',
        'prefecture',
        'city',
        'address1',
        'address2',
        'phone_number',
        'is_default',
    ];

    // Relationships
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
