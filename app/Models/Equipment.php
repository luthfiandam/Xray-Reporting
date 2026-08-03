<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipments';

    protected $fillable = [
        'uuid',
        'equipment_type_id',
        'location_id',
        'equipment_code',
        'name',
        'brand',
        'model',
        'view_mode',
        'serial_number',
        'generator_serial_a',
        'generator_serial_b',
        'detector_serial',
        'software_version',
        'firmware_version',
        'ip_address',
        'qr_code',
        'installation_date',
        'status',
        'notes',
    ];

    public $timestamps = true;

    protected function casts(): array
    {
        return [
            'installation_date' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // ✅ RELATIONSHIP
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class, 'equipment_type_id');
    }

    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class, 'equipment_id');
    }
}