<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evidence extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'evidences';

    protected $fillable = [
        'uuid',
        'work_order_id',
        'uploaded_by',
        'evidence_type',
        'original_path',
        'watermarked_path',
        'thumbnail_path',
        'original_name',
        'mime_type',
        'file_size',
        'width',
        'height',
        'caption',
        'sequence',
        'taken_at',
        'watermark_status',
    ];

    protected $casts = [
        'taken_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id');
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function ocrResult()
    {
        return $this->hasOne(OcrResult::class, 'evidence_id');
    }
}