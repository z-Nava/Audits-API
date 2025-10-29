<?php

namespace App\Http\Controllers\Web\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CatalogService;
use App\Models\ProductionLine;

class LineWebController extends Controller
{
    protected CatalogService $catalog;

    public function __construct(CatalogService $catalog)
    {
        $this->catalog = $catalog;
    }

    public function index(Request $request)
    {
        $lines = $this->catalog->listLines(['per_page' => 100]);
        return view('supervisor.lines.index', compact('lines'));
    }

    public function create()
    {
        return view('supervisor.lines.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'  => 'required|string|max:20',
            'name'  => 'required|string|max:100',
            'area'  => 'nullable|string|max:100',
            'active' => 'sometimes|boolean'
        ]);

        $this->catalog->createLine($data);
        return redirect()->route('supervisor.lines.index')->with('success', 'Línea creada correctamente.');
    }

    public function edit(ProductionLine $line)
    {
        return view('supervisor.lines.edit', compact('line'));
    }

    public function update(Request $request, ProductionLine $line)
    {
        $data = $request->validate([
            'code'  => 'required|string|max:20',
            'name'  => 'required|string|max:100',
            'area'  => 'nullable|string|max:100',
            'active' => 'sometimes|boolean'
        ]);

        $this->catalog->updateLine($line, $data);
        return redirect()->route('supervisor.lines.index')->with('success', 'Línea actualizada correctamente.');
    }

    public function destroy(ProductionLine $line)
    {
        $this->catalog->deleteLine($line);
        return redirect()->route('supervisor.lines.index')->with('success', 'Línea eliminada.');
    }
}
