<?php

namespace App\Services;

use App\Models\Evidence;
use App\Models\WorkOrder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EvidenceService
{
    protected string $storagePath = 'evidences';

    /**
     * Get evidence for work order
     */
    public function getByWorkOrder(int $workOrderId)
    {
        return Evidence::where('work_order_id', $workOrderId)
            ->with(['uploadedBy'])
            ->orderBy('sequence')
            ->get();
    }

    /**
     * Upload evidence
     */
    public function upload(
        WorkOrder $workOrder,
        UploadedFile $file,
        string $type,
        ?string $caption = null,
        int $uploadedBy = null
    ): Evidence {
        $uploadedBy = $uploadedBy ?? auth()->id();

        // Generate storage path
        $path = sprintf(
            '%s/%d/%s',
            $this->storagePath,
            $workOrder->id,
            Str::random(20) . '.' . $file->getClientOriginalExtension()
        );

        // Store file
        Storage::disk('local')->put($path, file_get_contents($file));

        // Create evidence record
        $evidence = Evidence::create([
            'work_order_id' => $workOrder->id,
            'uploaded_by' => $uploadedBy,
            'evidence_type' => $type,
            'original_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'caption' => $caption,
            'taken_at' => now(),
        ]);

        return $evidence;
    }

    /**
     * Delete evidence
     */
    public function delete(Evidence $evidence): bool
    {
        // Delete physical file
        if ($evidence->original_path && Storage::disk('local')->exists($evidence->original_path)) {
            Storage::disk('local')->delete($evidence->original_path);
        }

        // Soft delete record
        return $evidence->delete();
    }

    /**
     * Get evidence count for work order
     */
    public function getCountByWorkOrder(int $workOrderId): int
    {
        return Evidence::where('work_order_id', $workOrderId)->count();
    }

    /**
     * Get evidence by type
     */
    public function getByType(int $workOrderId, string $type)
    {
        return Evidence::where('work_order_id', $workOrderId)
            ->where('evidence_type', $type)
            ->orderBy('sequence')
            ->get();
    }
}