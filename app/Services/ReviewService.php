<?php

namespace App\Services;

use App\Models\Audit;
use App\Models\AuditReview;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReviewService
{
    public function listByAudit(Audit $audit)
    {
        return $audit->reviews()->with('supervisor:id,name,email')->latest('id')->get();
    }

    public function review(Audit $audit, array $data): Audit
    {
        if ($audit->status !== 'submitted') {
            throw ValidationException::withMessages([
                'status' => 'Solo se puede revisar una auditoría con estado SUBMITTED.'
            ]);
        }

        // (Opcional) valida que el supervisor que revisa sea el de la asignación:
        if ($audit->supervisor_id !== (int)$data['supervisor_id']) {
            throw ValidationException::withMessages([
                'supervisor_id' => 'Este supervisor no está asignado a la auditoría.'
            ]);
        }

        return DB::transaction(function () use ($audit, $data) {
            // Crear registro de revisión
            AuditReview::create([
                'audit_id'      => $audit->id,
                'supervisor_id' => $data['supervisor_id'],
                'decision'      => $data['decision'],
                'notes'         => $data['notes'] ?? null,
                'reviewed_at'   => $data['reviewed_at'] ?? now(),
            ]);

            // Transición de estado en Audit
            $newStatus = match ($data['decision']) {
                'approved'      => 'closed',
                'rejected'      => 'reviewed',      // queda en reviewed para que puedan rehacer o abrir nueva
                'needs_changes' => 'reviewed',      // pueden editar con un flujo que definas
                default         => 'reviewed',
            };

            $audit->update(['status' => $newStatus]);

            return $audit->fresh()->load([
                'assignment','technician','supervisor','line',
                'items.tool','reviews.supervisor'
            ]);
        });
    }

    /** (Opcional) revertir a in_progress si decisión fue needs_changes y tu flujo lo permite */
    public function reopen(Audit $audit): Audit
    {
        if ($audit->status !== 'reviewed') {
            throw ValidationException::withMessages([
                'status' => 'Solo se puede reabrir una auditoría en estado REVIEWED.'
            ]);
        }
        $audit->update(['status' => 'in_progress']);
        return $audit->fresh();
    }
}
