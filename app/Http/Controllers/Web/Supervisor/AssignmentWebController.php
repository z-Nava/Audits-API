<?php

namespace App\Http\Controllers\Web\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AssignmentService;
use App\Models\Assignment;
use App\Models\User;
use App\Models\ProductionLine;

class AssignmentWebController extends Controller
{
    protected AssignmentService $assignment;

    public function __construct(AssignmentService $assignment)
    {
        $this->assignment = $assignment;
    }

    public function index(Request $request)
    {
        $assignments = $this->assignment->list(['per_page' => 100]);
        return view('supervisor.assignments.index', compact('assignments'));
    }

    public function create()
    {
        $technicians = User::technicians()->active()->get();
        $lines = ProductionLine::active()->get();

        return view('supervisor.assignments.create', compact('technicians', 'lines'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'technician_id' => 'required|exists:users,id',
            'line_id'       => 'required|exists:production_lines,id',
            'shift'         => 'required|in:morning,evening,night',
            'assigned_at'   => 'required|date',
            'due_at'        => 'nullable|date|after_or_equal:assigned_at',
            'notes'         => 'nullable|string|max:500',
            'tools'         => 'nullable|array',
            'tools.*'       => 'exists:tools,id',
        ]);

        $data['supervisor_id'] = auth()->id();

        $this->assignment->create($data);

        return redirect()->route('supervisor.assignments.index')->with('success', 'Asignación creada correctamente.');
    }

    public function edit(Assignment $assignment)
    {
        $technicians = User::technicians()->active()->get();
        $lines = ProductionLine::active()->get();

        return view('supervisor.assignments.edit', compact('assignment', 'technicians', 'lines'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        $data = $request->validate([
            'technician_id' => 'required|exists:users,id',
            'line_id'       => 'required|exists:production_lines,id',
            'shift'         => 'required|in:morning,evening,night',
            'assigned_at'   => 'required|date',
            'due_at'        => 'nullable|date|after_or_equal:assigned_at',
            'notes'         => 'nullable|string|max:500',
        ]);

        $this->assignment->update($assignment, $data);

        return redirect()->route('supervisor.assignments.index')->with('success', 'Asignación actualizada.');
    }

    public function destroy(Assignment $assignment)
    {
        $assignment->delete();

        return redirect()->route('supervisor.assignments.index')->with('success', 'Asignación eliminada.');
    }
}
