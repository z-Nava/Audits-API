<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuditRequest;
use App\Http\Requests\UpdateAuditRequest;
use App\Http\Requests\SubmitAuditRequest;
use App\Models\Audit;
use App\Services\AuditService;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function __construct(private AuditService $service){}

    public function index(Request $request)
    {
        $items = $this->service->list($request->all());
        return response()->json($items, 200);
    }

    public function store(StoreAuditRequest $request)
    {
        $audit = $this->service->startFromAssignment($request->validated());
        return response()->json($audit, 201);
    }

    public function show(Audit $audit)
    {
        return response()->json(
            $audit->load(['assignment','technician','supervisor','line','items.tool']),
            200
        );
    }
    
    public function update(UpdateAuditRequest $request, Audit $audit)
    {
        $updated = $this->service->update($audit, $request->validated());
        return response()->json($updated, 200);
    }

    public function submit(SubmitAuditRequest $request, Audit $audit)
    {
        $updated = $this->service->submit($audit, $request->input('ended_at'));
        return response()->json($updated, 200);
    }


}
