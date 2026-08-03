<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChecklistTemplate extends Model
{
    use HasFactory;

    protected $table = 'checklist_templates';

    protected $fillable = [
        'uuid',
        'equipment_type_id',
        'maintenance_frequency_id',
        'name',
        'version',
        'description',
        'is_active',
        'effective_from',
        'effective_until',
    ];

    public $timestamps = true;

    protected function casts(): array
    {
        return [
            'effective_from' => 'date',
            'effective_until' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // ✅ RELATIONSHIP
    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class, 'equipment_type_id');
    }

    public function maintenanceFrequency()
    {
        return $this->belongsTo(MaintenanceFrequency::class, 'maintenance_frequency_id');
    }

    public function items()
    {
        return $this->hasMany(ChecklistTemplateItem::class, 'checklist_template_id');
    }

    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class, 'checklist_template_id');
    }
}