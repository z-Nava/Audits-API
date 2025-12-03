<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreAuditItemRequest;
use App\Http\Requests\UpdateAuditItemRequest;
use App\Models\Audit;
use App\Models\AuditItem;
use App\Services\AuditService;
use Illuminate\Support\Facades\Log;

class AuditItemController extends Controller
{
    public function __construct(private AuditService $service) {}

    /** POST /audits/{audit}/items */
    public function store(StoreAuditItemRequest $request, Audit $audit)
    {
        $item = $this->service->addItem($audit, $request->validated());
        Log::info('➕ Creating AuditItem', $request->all());
        return response()->json($item->fresh()->load('tool'), 201);
    }

    /** PUT /audit-items/{item} */
    public function update(UpdateAuditItemRequest $request, AuditItem $item)
    {
        Log::info('🔹 REQUEST updateItem:', $request->all());
        Log::info('🔹 BEFORE updateItem (DB):', $item->toArray());
        $updated = $this->service->updateItem($item, $request->validated());

        Log::info('📌 AFTER updateItem (DB):', $updated->fresh()->toArray());

        return response()->json($updated->fresh()->load('tool'), 200);
    }

    /** GET /audits/{audit}/items */
    public function index(Audit $audit)
    {
        return response()->json($audit->items()->with('tool')->get(), 200);
    }
}
