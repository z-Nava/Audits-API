<?php

namespace App\Http\Controllers\Web\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Services\AssignmentService;
use Illuminate\Http\Request;

class AssignmentsController extends Controller
{
    public function __construct(private AssignmentService $service) {}

    public function index(Request $request)
    {
        $filters = $request->only(['technician_id','line_id','shift','status','from','to','per_page']);
        $assignments = $this->service->list($filters);
        return view('supervisor.assignments.index', compact('assignments','filters'));
    }

    public function show(Assignment $assignment)
    {
        $assignment->load(['supervisor','technician','line','tools']);
        return view('supervisor.assignments.show', compact('assignment'));
    }

    public function updateStatus(Request $request, Assignment $assignment)
    {
        $data = $request->validate(['status' => 'required|in:assigned,in_progress,completed,cancelled']);
        $updated = $this->service->updateStatus($assignment, $data['status']);
        return redirect()->route('assignments.show', $updated)->with('ok', 'Estado actualizado.');
    }
}
