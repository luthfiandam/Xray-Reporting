<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChecklistResult extends Model
{
    use HasFactory;

    protected $table = 'checklist_results';

    protected $fillable = [
        'work_order_id',
        'checklist_template_item_id',
        'completed_by',
        'item_code',
        'item_name',
        'input_type',
        'result_status',
        'value_text',
        'value_number',
        'value_json',
        'notes',
        'sequence',
        'completed_at',
    ];

    protected $casts = [
        'value_number' => 'decimal:6',
        'value_json' => 'array',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id');
    }

    public function checklistTemplateItem()
    {
        return $this->belongsTo(ChecklistTemplateItem::class, 'checklist_template_item_id');
    }

    public function completedBy()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }
}