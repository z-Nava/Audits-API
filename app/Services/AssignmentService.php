<?php

namespace App\Services;

use App\Models\Assignment;
use App\Models\Tool;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class AssignmentService
{
    public function list(array $filters = []): LengthAwarePaginator|Collection
    {
        $q = Assignment::query()
            ->with(['supervisor:id,name,email',
                'technician:id,name,email',
                'line:id,code,name',
                'tools:id,code,name,model' 
            ]);

            if(!empty($filters['supervisor_id'])) $q->where('supervisor_id', (int)$filters['supervisor_id']);
            if(!empty($filters['technician_id'])) $q->where('technician_id', (int)$filters['technician_id']);
            if(!empty($filters['line_id'])) $q->where('line_id', (int)$filters['line_id']);
            if(!empty($filters['shift'])) $q->where('shift', $filters['shift']);

            if(!empty($filters['from'])) $q->whereDate('assigned_at', '>=', $filters['from']);
            if(!empty($filters['to'])) $q->whereDate('assigned_at', '<=', $filters['to']);

            $q->latest('id');

            $perPage = (int)($filters['per_page'] ?? 10);
            return $perPage > 0 ? $q->paginate($perPage) : $q->get();
    }

    public function create(array $data): Assignment
    {
        return DB::transaction(function () use ($data) {
            $assignment = Assignment::create([
                'supervisor_id' => $data['supervisor_id'],
                'technician_id' => $data['technician_id'],
                'line_id' => $data['line_id'],
                'shift' => $data['shift'],
                'status' => 'assigned',
                'assigned_at' => $data['assigned_at'],
                'due_at' => $data['due_at'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);

            if(!empty($data['tools']))
            {
                $this->ensureToolsBelongToLine($data['tools'], $assignment['line_id']);
                $assignment->tools()->attach(array_unique($data['tools']));
            }

            return $assignment -> load(['supervisor', 'technician', 'line', 'tools']);
        });
    }

    public function update(Assignment $assignment, array $data): Assignment
    {
        $assignment->update($data);
        return $assignment->load(['supervisor', 'technician', 'line', 'tools']);
    }

    public function updateStatus(Assignment $assignment, string $newStatus): Assignment
    {
        $valid = [ 'assigned', 'in_progress', 'completed', 'cancelled' ];
        if(!in_array($newStatus, $valid, true))
        {
            throw ValidationException::withMessages(['status' => 'Invalid status value.']);
        }

        $from = $assignment->status;
        $allowed = match($from) {
            'assigned' => ['in_progress', 'cancelled'],
            'in_progress' => ['completed', 'cancelled'],
            'completed' => [],
            'cancelled' => [],
            default => []
        };
        
        if(!in_array($newStatus, $allowed, true))
        {
            throw ValidationException::withMessages(['status' => "Status transition from '$from' to '$newStatus' is not allowed."]);
        }

        $assignment->update(['status' => $newStatus]);
        return $assignment->load(['supervisor', 'technician', 'line', 'tools']);
    }

    public function addTools(Assignment $assignment, array $toolIds): Assignment
    {
        $this->ensureToolsBelongToLine($toolIds, $assignment->line_id);

        $ids = array_unique($toolIds);
        $assignment->tools()->syncWithoutDetaching($ids);

        return $assignment->load('tools');
    }

    public function removeTool(Assignment $assignment, Tool $tool): Assignment
    {
        $assignment->tools()->detach($tool->id);
        return $assignment->load('tools');
    }

    /** Lista de tools de la asignación */
    public function listTools(Assignment $assignment): Collection
    {
        return $assignment->tools()->get();
    }

    /** Reglas de negocio: tools deben pertenecer a la misma línea (si así lo decides) */
    protected function ensureToolsBelongToLine(array $toolIds, int $lineId): void
    {
        $count = Tool::whereIn('id', $toolIds)
                     ->where(function ($q) use ($lineId) {
                         $q->where('line_id', $lineId)
                           ->orWhereNull('line_id'); // permite nulas si quieres
                     })->count();

        if ($count !== count(array_unique($toolIds))) {
            throw ValidationException::withMessages([
                'tools' => 'Algunas herramientas no pertenecen a la línea de la asignación o no existen.'
            ]);
        }
    }
}