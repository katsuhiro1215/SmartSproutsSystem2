<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $table = 'organizations';

    protected $fillable = [
        'type',
        'name',
        'description',
        'email',
        'organization_photo_path',
        'organization_logo_path',
        'postalcode',
        'prefecture',
        'city',
        'address1',
        'address2',
        'phone_number',
        'fax_number',
        'status',
        'established_date',
        'website',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'line',
    ];

    // Relationships
    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'admin_organization', 'organization_id', 'admin_id');
    }

    public function stores()
    {
        return $this->hasMany(Store::class);
    }
}
