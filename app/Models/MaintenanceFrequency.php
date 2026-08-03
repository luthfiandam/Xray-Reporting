<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaintenanceFrequency extends Model
{
    use HasFactory;

    protected $table = 'maintenance_frequencies';

    protected $fillable = [
        'code',
        'name',
        'interval_days',
        'sequence',
        'is_active',
    ];

    public $timestamps = true;

    // ✅ RELATIONSHIP
    public function checklistTemplates()
    {
        return $this->hasMany(ChecklistTemplate::class, 'maintenance_frequency_id');
    }

    public function measurementTemplates()
    {
        return $this->hasMany(MeasurementTemplate::class, 'maintenance_frequency_id');
    }

    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class, 'maintenance_frequency_id');
    }
}