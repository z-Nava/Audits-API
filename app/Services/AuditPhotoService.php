<?php

namespace App\Services;

use App\Models\AuditItem;
use App\Models\AuditPhoto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AuditPhotoService
{
    public function listByItem(AuditItem $item)
    {
        return $item->photos()->get();
    }

    public function storeForItem(AuditItem $item, \Illuminate\Http\UploadedFile $file, ?string $caption = null, ?string $takenAt = null): AuditPhoto
    {
        if ($item->audit->status !== 'in_progress') {
            throw ValidationException::withMessages(['status' => 'Photos can only be uploaded when the audit is in progress.']);
        }

        $auditCode = $item->audit->audit_code;
        $path = $file->store("audits/{$auditCode}/items/{$item->id}", 'public');

        return AuditPhoto::create([
            'audit_item_id' => $item->id,
            'path'          => $path,
            'caption'       => $caption,
            'taken_at'      => $takenAt,
            'meta'          => null, 
        ]);
    }

    public function delete(AuditPhoto $photo): void
    {
        Storage::disk('public')->delete($photo->path);
        $photo->delete();
    }
}
