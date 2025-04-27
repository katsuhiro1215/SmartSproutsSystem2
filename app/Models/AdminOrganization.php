<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminOrganization extends Model
{
    use HasFactory;

    protected $table = 'admin_organization';

    protected $fillable = [
        'admin_id',
        'organization_id',
        'status'
    ];

    // Relationships
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
    
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}
