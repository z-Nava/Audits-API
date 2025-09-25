<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreAuditPhotoRequest;
use App\Models\AuditItem;
use App\Models\AuditPhoto;
use App\Services\AuditPhotoService;


class AuditPhotoController extends Controller
{
    public function __construct(private AuditPhotoService $service) {}

    /** GET /audit-items/{item}/photos */
    public function index(AuditItem $item)
    {
        return response()->json($this->service->listByItem($item), 200);
    }

    /** POST /audit-items/{item}/photos */
    public function store(StoreAuditPhotoRequest $request, AuditItem $item)
    {
        $photo = $this->service->storeForItem(
            $item,
            $request->file('photo'),
            $request->input('caption'),
            $request->input('taken_at')
        );

        return response()->json($photo, 201);
    }

    /** DELETE /audit-photos/{photo} */
    public function destroy(AuditPhoto $photo)
    {
        $this->service->delete($photo);
        return response()->json(null, 204);
    }
}
