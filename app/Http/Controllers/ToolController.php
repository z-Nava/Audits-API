<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Http\Requests\StoreToolRequest;
use App\Http\Requests\UpdateToolRequest;
use App\Services\CatalogService;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function __construct(protected CatalogService $catalog){}

    public function index(Request $request)
    {
        $tools = $this->catalog->listTools($request->all());
        return response()->json($tools, 200);
    }

    public function store(StoreToolRequest $request)
    {
       $tool = $this->catalog->createTool($request->validated());
        return response()->json($tool, 201);
    }

    public function show(Tool $tool)
    {
        return response()->json($tool->load('line'), 200);
    }

    public function update(UpdateToolRequest $request, Tool $tool)
    {
        $tool = $this->catalog->updateTool($tool, $request->validated());
        return response()->json($tool, 200);
    }

    public function destroy(Tool $tool)
    {
        $this->catalog->deleteTool($tool);
        return response()->json(null, 204);
    }
}
