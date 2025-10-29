<?php

namespace App\Http\Controllers\Web\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuditService;
use App\Models\Audit;

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

    public function show(Audit $audit)
    {
        $audit->load([
            'assignment.line',
            'technician',
            'supervisor',
            'line',
            'items.tool',
            'reviews.supervisor',
        ]);

        return view('supervisor.audits.show', compact('audit'));
    }

    public function review(Request $request, Audit $audit)
    {
        $data = $request->validate([
            'decision' => 'required|in:approved,rejected,needs_changes',
            'notes'    => 'nullable|string|max:500',
        ]);

        $data['supervisor_id'] = auth()->id();
        $data['reviewed_at'] = now();

        $this->review->review($audit, $data);

        return redirect()->route('supervisor.audits.show', $audit->id)
                        ->with('success', 'Revisión registrada correctamente.');
    }
}
