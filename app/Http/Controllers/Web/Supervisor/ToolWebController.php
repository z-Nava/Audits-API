<?php

namespace App\Http\Controllers\Web\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CatalogService;

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
}
