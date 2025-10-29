<?php

namespace App\Http\Controllers\Web\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AssignmentService;

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
}
