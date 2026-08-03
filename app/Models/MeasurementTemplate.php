<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MeasurementTemplate extends Model
{
    use HasFactory;

    protected $table = 'measurement_templates';

    protected $fillable = [
        'equipment_type_id',
        'maintenance_frequency_id',
        'code',
        'name',
        'generator',
        'unit',
        'minimum_value',
        'maximum_value',
        'decimal_precision',
        'sequence',
        'is_required',
        'is_ocr_enabled',
        'is_active',
    ];

    public $timestamps = true;

    protected function casts(): array
    {
        return [
            'minimum_value' => 'decimal:6',
            'maximum_value' => 'decimal:6',
            'is_required' => 'boolean',
            'is_ocr_enabled' => 'boolean',
            'is_active' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class, 'equipment_type_id');
    }

    public function maintenanceFrequency()
    {
        return $this->belongsTo(MaintenanceFrequency::class, 'maintenance_frequency_id');
    }
}