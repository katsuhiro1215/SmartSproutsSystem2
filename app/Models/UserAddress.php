<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $table = 'user_addresses';

    protected $fillable = [
        'user_id',
        'postal_code',
        'prefecture',
        'city',
        'address1',
        'address2',
        'phone_number',
        'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
