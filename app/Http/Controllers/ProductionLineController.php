<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CatalogService;
use App\Http\Requests\StoreProductionLineRequest;
use App\Http\Requests\UpdateProductionLineRequest;
use App\Models\ProductionLine;

class ProductionLineController extends Controller
{
    public function __construct(protected CatalogService $catalog){}
    
    public function index(Request $request)
    {
        $lines = $catalog = $this->catalog->listLines($request->all());
        return response()->json($lines, 200);
    }

    public function store(StoreProductionLineRequest $request)
    {
        $line = $this->catalog->createLine($request->validated());
        return response()->json($line, 201);
    }

    public function show(ProductionLine $line)
    {
        return response()->json($line, 200);
    }

    public function update(UpdateProductionLineRequest $request, ProductionLine $line)
    {
        $line = $this->catalog->updateLine($line, $request->validated());
        return response()->json($line, 200);
    }

    public function destroy(ProductionLine $line)
    {
        $this->catalog->deleteLine($line);
        return response()->json(null, 204);
    }
}
