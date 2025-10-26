<?php

namespace App\Http\Controllers\Web\Supervisor;

use App\Http\Controllers\Controller;
use App\Services\AssignmentService;
use App\Services\AuditService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private AssignmentService $assignments,
        private AuditService $audits
    ) {}

    public function index(Request $request)
    {
        // KPIs rápidos (podrías optimizarlos con queries agregadas)
        $assigned   = $this->assignments->list(['status' => 'assigned', 'per_page' => 0])->count();
        $inProgress = $this->assignments->list(['status' => 'in_progress', 'per_page' => 0])->count();
        $submitted  = $this->audits->list(['status' => 'submitted', 'per_page' => 0])->count();
        $closed     = $this->audits->list(['status' => 'closed', 'per_page' => 0])->count();

        // Últimas auditorías
        $latestAudits = $this->audits->list(['per_page' => 5]);

        return view('supervisor.dashboard', compact('assigned','inProgress','submitted','closed','latestAudits'));
    }
}
