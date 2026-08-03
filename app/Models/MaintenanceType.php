<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaintenanceType extends Model
{
    use HasFactory;

    protected $table = 'maintenance_types';

    protected $fillable = [
        'code',
        'name',
        'description',
        'is_active',
    ];

    public $timestamps = true;

    // ✅ RELATIONSHIP
    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class, 'maintenance_type_id');
    }
}