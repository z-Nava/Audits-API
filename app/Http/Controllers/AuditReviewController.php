<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuditReviewRequest;
use App\Models\Audit;
use App\Services\ReviewService;

class AuditReviewController extends Controller
{
    public function __construct(private ReviewService $service) {}

    /** GET /audits/{audit}/reviews */
    public function index(Audit $audit)
    {
        return response()->json($this->service->listByAudit($audit), 200);
    }

    /** POST /audits/{audit}/reviews */
    public function store(StoreAuditReviewRequest $request, Audit $audit)
    {
        $reviewed = $this->service->review($audit, $request->validated());
        return response()->json($reviewed, 201);
    }

    /** (Opcional) POST /audits/{audit}/reopen */
    public function reopen(Audit $audit)
    {
        $audit = $this->service->reopen($audit);
        return response()->json($audit, 200);
    }
}
