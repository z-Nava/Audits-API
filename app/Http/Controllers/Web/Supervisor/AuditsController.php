<?php

namespace App\Http\Controllers\Web\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use App\Services\AuditService;
use App\Services\ReviewService;
use Illuminate\Http\Request;

class AuditsController extends Controller
{
    public function __construct(
        private AuditService $audits,
        private ReviewService $reviews
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['technician_id','supervisor_id','line_id','shift','status','result','from','to','per_page']);
        $items = $this->audits->list($filters);
        return view('supervisor.audits.index', compact('items','filters'));
    }

    public function show(Audit $audit)
    {
        $audit->load(['assignment','technician','supervisor','line','items.tool','reviews.supervisor']);
        return view('supervisor.audits.show', compact('audit'));
    }

    public function review(Request $request, Audit $audit)
    {
        $data = $request->validate([
            'supervisor_id' => 'required|integer',
            'decision'      => 'required|in:approved,rejected,needs_changes',
            'notes'         => 'nullable|string'
        ]);
        $this->reviews->review($audit, $data);
        return redirect()->route('audits.show', $audit)->with('ok', 'Revisión registrada.');
    }

    public function reopen(Audit $audit)
    {
        $this->reviews->reopen($audit);
        return redirect()->route('audits.show', $audit)->with('ok', 'Auditoría reabierta.');
    }
}
