<?php

namespace App\Http\Controllers\Web\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuditService;
use App\Models\Audit;
use App\Services\ReviewService;

class AuditWebController extends Controller
{
    protected AuditService $audit;
    protected $review;

    public function __construct(AuditService $audit, ReviewService $review)
    {
        $this->audit = $audit;
        $this->review = $review;
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

    public function reopen(Audit $audit)
    {
        try {
            $this->$audit->reopen($audit);
            return redirect()
                ->route('supervisor.audits.show', $audit->id)
                ->with('success', 'La auditoría ha sido reabierta correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->route('supervisor.audits.show', $audit->id)
                ->withErrors($e->errors());
        }
    }

}
