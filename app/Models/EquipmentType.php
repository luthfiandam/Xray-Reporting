<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EquipmentType extends Model
{
    use HasFactory;

    protected $table = 'equipment_types';

    protected $fillable = [
        'code',
        'name',
        'description',
        'is_active',
    ];

    public $timestamps = true;

    public function equipments()
    {
        return $this->hasMany(Equipment::class, 'equipment_type_id');
    }

    public function checklistTemplates()
    {
        return $this->hasMany(ChecklistTemplate::class, 'equipment_type_id');
    }

    public function measurementTemplates()
    {
        return $this->hasMany(MeasurementTemplate::class, 'equipment_type_id');
    }
}