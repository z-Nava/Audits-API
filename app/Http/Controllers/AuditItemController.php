<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreAuditItemRequest;
use App\Http\Requests\UpdateAuditItemRequest;
use App\Models\Audit;
use App\Models\AuditItem;
use App\Services\AuditService;

class AuditItemController extends Controller
{
    public function __construct(private AuditService $service) {}

    /** POST /audits/{audit}/items */
    public function store(StoreAuditItemRequest $request, Audit $audit)
    {
        $item = $this->service->addItem($audit, $request->validated());
        return response()->json($item->load('tool'), 201);
    }

    /** PUT /audit-items/{item} */
    public function update(UpdateAuditItemRequest $request, AuditItem $item)
    {
        $updated = $this->service->updateItem($item, $request->validated());
        return response()->json($updated->load('tool'), 200);
    }

    /** GET /audits/{audit}/items */
    public function index(Audit $audit)
    {
        return response()->json($audit->items()->with('tool')->get(), 200);
    }
}
