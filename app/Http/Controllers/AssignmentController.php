<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssignmentRequest;
use App\Http\Requests\UpdateAssigmentStatusRequest;
use App\Http\Requests\UpdateAssignmentRequest;
use App\Models\Assignment;
use App\Services\AssignmentService;
use Illuminate\Http\Request;


class AssignmentController extends Controller
{
    public function __construct(private AssignmentService $service){}

    public function index(Request $request)
    {
        $items = $this->service->list($request->all());
        return response()->json($items, 200);
    }

    public function store(StoreAssignmentRequest $request)
    {
        $assignment = $this->service->create($request->validated());
        return response()->json($assignment, 201);
    }

    public function show(Assignment $assignment)
    {
        return response()->json($assignment->load(['supervisor', 'technician', 'line', 'tools']), 200);
    }

    public function update(UpdateAssignmentRequest $request, Assignment $assignment)
    {
        $updated = $this->service->update($assignment, $request->validated());
        return response()->json($updated, 200);
    }

    public function updateStatus(UpdateAssigmentStatusRequest $request, Assignment $assignment)
    {
        $updated = $this->service->updateStatus($assignment, $request->validated()['status']);
        return response()->json($updated, 200);
    }

    public function destroy(Assignment $assignment)
    {
        $assignment->delete();
        return response()->json(null, 204);
    }
}
