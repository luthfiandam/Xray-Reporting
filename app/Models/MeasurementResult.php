<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MeasurementResult extends Model
{
    use HasFactory;

    protected $table = 'measurement_results';

    protected $fillable = [
        'work_order_id',
        'measurement_template_id',
        'ocr_result_id',
        'confirmed_by',
        'measurement_code',
        'measurement_name',
        'generator',
        'unit',
        'ocr_value',
        'manual_value',
        'final_value',
        'minimum_value',
        'maximum_value',
        'is_within_range',
        'input_source',
        'confidence',
        'validation_status',
        'notes',
        'confirmed_at',
    ];

    protected $casts = [
        'ocr_value' => 'decimal:6',
        'manual_value' => 'decimal:6',
        'final_value' => 'decimal:6',
        'minimum_value' => 'decimal:6',
        'maximum_value' => 'decimal:6',
        'is_within_range' => 'boolean',
        'confidence' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id');
    }

    public function measurementTemplate()
    {
        return $this->belongsTo(MeasurementTemplate::class, 'measurement_template_id');
    }

    public function ocrResult()
    {
        return $this->belongsTo(OcrResult::class, 'ocr_result_id');
    }

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }
}