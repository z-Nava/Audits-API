<?php

namespace App\Services;

use App\Models\Audit;
use App\Models\Assignment;
use App\Models\AuditItem;
use App\Models\Tool;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AuditService
{
    /** Listar auditorías con filtros */
    public function list(array $filters = []): LengthAwarePaginator|Collection
    {
        $q = Audit::query()
            ->with([
                'assignment:id,supervisor_id,technician_id,line_id,shift,status',
                'technician:id,name,email',
                'supervisor:id,name,email',
                'line:id,code,name',
            ]);

        if (!empty($filters['assignment_id'])) $q->where('assignment_id', (int)$filters['assignment_id']);
        if (!empty($filters['technician_id'])) $q->where('technician_id', (int)$filters['technician_id']);
        if (!empty($filters['supervisor_id'])) $q->where('supervisor_id', (int)$filters['supervisor_id']);
        if (!empty($filters['line_id']))       $q->where('line_id', (int)$filters['line_id']);
        if (!empty($filters['shift']))         $q->where('shift', $filters['shift']);
        if (!empty($filters['status']))        $q->where('status', $filters['status']);
        if (!empty($filters['result']))        $q->where('overall_result', $filters['result']);
        if (!empty($filters['from']))          $q->whereDate('created_at', '>=', $filters['from']);
        if (!empty($filters['to']))            $q->whereDate('created_at', '<=', $filters['to']);

        $q->latest('id');

        $perPage = (int)($filters['per_page'] ?? 10);
        return $perPage > 0 ? $q->paginate($perPage) : $q->get();
    }

    /** Iniciar auditoría desde una asignación */
    public function startFromAssignment(array $data): Audit
    {
        return DB::transaction(function () use ($data) {
            $assignment = Assignment::with(['line','supervisor','technician','tools'])->findOrFail($data['assignment_id']);

            // Validaciones de negocio
            if ($assignment->technician_id !== (int)$data['technician_id']) {
                throw ValidationException::withMessages(['technician_id' => 'El técnico no coincide con la asignación.']);
            }
            if (!in_array($assignment->status, ['assigned','in_progress'], true)) {
                throw ValidationException::withMessages(['assignment_id' => 'La asignación no permite iniciar auditoría.']);
            }
            $employeeOk = \App\Models\User::where('employee_number', $data['employee_number'])
                              ->where('active', true)
                              ->exists();

            if (!$employeeOk) {
                throw ValidationException::withMessages([
                    'employee_number' => 'Número de empleado inválido o inactivo.'
                ]);
            }

            // Crear auditoría
            $audit = Audit::create([
                'assignment_id'   => $assignment->id,
                'technician_id'   => $assignment->technician_id,
                'supervisor_id'   => $assignment->supervisor_id,
                'employee_number' => $data['employee_number'],
                'audit_code'      => 'AUD-'.now()->format('Ymd').'-'.Str::upper(Str::random(5)),
                'line_id'         => $assignment->line_id,
                'shift'           => $data['shift'] ?? $assignment->shift,
                'status'          => 'in_progress',
                'summary'         => $data['summary'] ?? null,
                'overall_result'  => null,
                'started_at'      => $data['started_at'] ?? now(),
                'ended_at'        => null,
            ]);

            // Poner asignación en progreso si estaba "assigned"
            if ($assignment->status === 'assigned') {
                $assignment->update(['status' => 'in_progress']);
            }

            return $audit->load(['assignment','technician','supervisor','line']);
        });
    }

    /** Actualizar metadatos (summary/timestamps) mientras está en progreso */
    public function update(Audit $audit, array $data): Audit
    {
        if (!in_array($audit->status, ['in_progress','draft'], true)) {
            throw ValidationException::withMessages(['status' => 'La auditoría no se puede editar en este estado.']);
        }
        $audit->update($data);
        return $audit->load(['assignment','technician','supervisor','line']);
    }

    /** Agregar ítem (resultado por herramienta) */
    public function addItem(Audit $audit, array $data): AuditItem
    {
        if ($audit->status !== 'in_progress') {
            throw ValidationException::withMessages(['status' => 'Solo se pueden agregar ítems en progreso.']);
        }

        // La herramienta debe estar en la asignación
        $tool = Tool::findOrFail($data['tool_id']);
        $assignmentToolIds = $audit->assignment->tools()->pluck('tools.id')->all();
        if (!in_array($tool->id, $assignmentToolIds, true)) {
            throw ValidationException::withMessages(['tool_id' => 'La herramienta no pertenece a la asignación.']);
        }

        return AuditItem::create([
            'audit_id' => $audit->id,
            'tool_id'  => $tool->id,
            'result'   => $data['result'],
            'comments' => $data['comments'] ?? null,
            'defects'  => $data['defects'] ?? null,
        ]);
    }

    /** Editar ítem */
    public function updateItem(AuditItem $item, array $data): AuditItem
    {
        if ($item->audit->status !== 'in_progress') {
            throw ValidationException::withMessages(['status' => 'No se puede editar ítems cuando la auditoría no está en progreso.']);
        }
        $item->update($data);
        return $item;
    }

    /** Enviar auditoría (calcula overall_result y cierra edición) */
    public function submit(Audit $audit, ?string $endedAt = null): Audit
    {
        if ($audit->status !== 'in_progress') {
            throw ValidationException::withMessages(['status' => 'Solo se puede enviar una auditoría en progreso.']);
        }

        $items = $audit->items()->get();
        if ($items->count() === 0) {
            throw ValidationException::withMessages(['items' => 'La auditoría debe tener al menos un ítem.']);
        }

        // Regla simple: si algún FAIL → overall FAIL; si todos PASS → PASS; si mezcla PASS/NA → PASS (ajústalo si necesitas)
        $hasFail = $items->contains(fn($i) => $i->result === 'FAIL');
        $allPass = $items->every(fn($i) => $i->result === 'PASS');

        $overall = $hasFail ? 'FAIL' : ($allPass ? 'PASS' : 'PASS');

        $audit->update([
            'status'         => 'submitted',
            'overall_result' => $overall,
            'ended_at'       => $endedAt ?: now(),
        ]);

        return $audit->fresh()->load(['assignment','technician','supervisor','line','items']);
    }
}
