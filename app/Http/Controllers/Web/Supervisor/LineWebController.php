<?php

namespace App\Http\Controllers\Web\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CatalogService;

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
}
