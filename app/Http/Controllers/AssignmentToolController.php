<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AttachToolsRequest;
use App\Models\Assignment;
use App\Models\Tool;
use App\Services\AssignmentService;

class AssignmentToolController extends Controller
{
    public function __construct(private AssignmentService $service) {}

    /** GET /assignments/{assignment}/tools */
    public function index(Assignment $assignment)
    {
        return response()->json($this->service->listTools($assignment), 200);
    }

    /** POST /assignments/{assignment}/tools  body: { tools: [1,2,3] } */
    public function attach(AttachToolsRequest $request, Assignment $assignment)
    {
        $updated = $this->service->addTools($assignment, $request->validated()['tools']);
        return response()->json($updated->tools, 200);
    }

    /** DELETE /assignments/{assignment}/tools/{tool} */
    public function detach(Assignment $assignment, Tool $tool)
    {
        $updated = $this->service->removeTool($assignment, $tool);
        return response()->json($updated->tools, 200);
    }  
}
