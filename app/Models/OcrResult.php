<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OcrResult extends Model
{
    use HasFactory;

    protected $table = 'ocr_results';

    protected $fillable = [
        'work_order_id',
        'evidence_id',
        'reviewed_by',
        'engine_name',
        'engine_version',
        'status',
        'raw_text',
        'parsed_values',
        'confidence_json',
        'average_confidence',
        'processing_time_ms',
        'error_message',
        'reviewed_at',
        'review_status',
    ];

    protected $casts = [
        'parsed_values' => 'array',
        'confidence_json' => 'array',
        'average_confidence' => 'decimal:2',
        'reviewed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id');
    }

    public function evidence()
    {
        return $this->belongsTo(Evidence::class, 'evidence_id');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function measurementResults()
    {
        return $this->hasMany(MeasurementResult::class, 'ocr_result_id');
    }
}