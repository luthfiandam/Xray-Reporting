<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'work_orders';

    protected $fillable = [
        'uuid',
        'work_order_number',
        'equipment_id',
        'maintenance_type_id',
        'maintenance_frequency_id',
        'checklist_template_id',
        'created_by',
        'assigned_to',
        'approved_by',
        'status',
        'priority',
        'scheduled_at',
        'started_at',
        'submitted_at',
        'approved_at',
        'closed_at',
        'problem_description',
        'action_taken',
        'final_condition',
        'notes',
        'ocr_reviewed',
        'sync_status',
    ];

    public $timestamps = true;

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'started_at' => 'datetime',
            'submitted_at' => 'datetime',
            'approved_at' => 'datetime',
            'closed_at' => 'datetime',
            'ocr_reviewed' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }

    public function maintenanceType()
    {
        return $this->belongsTo(MaintenanceType::class, 'maintenance_type_id');
    }

    public function maintenanceFrequency()
    {
        return $this->belongsTo(MaintenanceFrequency::class, 'maintenance_frequency_id');
    }

    public function checklistTemplate()
    {
        return $this->belongsTo(ChecklistTemplate::class, 'checklist_template_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}