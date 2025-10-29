<?php

namespace App\Http\Controllers\Web\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CatalogService;
use App\Models\Tool;
use App\Models\ProductionLine;

class ToolWebController extends Controller
{
    protected CatalogService $catalog;

    public function __construct(CatalogService $catalog)
    {
        $this->catalog = $catalog;
    }

    public function index(Request $request)
    {
        $tools = $this->catalog->listTools(['per_page' => 100]);
        return view('supervisor.tools.index', compact('tools'));
    }

    public function create()
    {
        $lines = ProductionLine::active()->get();
        return view('supervisor.tools.create', compact('lines'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'     => 'required|string|max:20',
            'name'     => 'required|string|max:100',
            'model'    => 'nullable|string|max:100',
            'line_id'  => 'nullable|exists:production_lines,id',
            'active'   => 'sometimes|boolean'
        ]);

        $this->catalog->createTool($data);
        return redirect()->route('supervisor.tools.index')->with('success', 'Herramienta creada correctamente.');
    }

    public function edit(Tool $tool)
    {
        $lines = ProductionLine::active()->get();
        return view('supervisor.tools.edit', compact('tool', 'lines'));
    }

    public function update(Request $request, Tool $tool)
    {
        $data = $request->validate([
            'code'     => 'required|string|max:20',
            'name'     => 'required|string|max:100',
            'model'    => 'nullable|string|max:100',
            'line_id'  => 'nullable|exists:production_lines,id',
            'active'   => 'sometimes|boolean'
        ]);

        $this->catalog->updateTool($tool, $data);
        return redirect()->route('supervisor.tools.index')->with('success', 'Herramienta actualizada correctamente.');
    }

    public function destroy(Tool $tool)
    {
        $this->catalog->deleteTool($tool);
        return redirect()->route('supervisor.tools.index')->with('success', 'Herramienta eliminada.');
    }
}
