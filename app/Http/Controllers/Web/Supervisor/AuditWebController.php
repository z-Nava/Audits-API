<?php

namespace App\Http\Controllers\Web\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuditService;

class AuditWebController extends Controller
{
    protected AuditService $audit;

    public function __construct(AuditService $audit)
    {
        $this->audit = $audit;
    }

    public function index(Request $request)
    {
        $audits = $this->audit->list(['per_page' => 100]);
        return view('supervisor.audits.index', compact('audits'));
    }
}
