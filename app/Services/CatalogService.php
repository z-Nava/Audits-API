<?php

namespace App\Services;

use App\Models\ProductionLine;
use App\Models\Tool;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Employee;

class CatalogService
{
    /** PRODUCTION LINES */
    public function listLines(array $filters = []): LengthAwarePaginator|Collection
    {
        $q = ProductionLine::query();

        if (!empty($filters['q'])) {
            $term = trim($filters['q']);
            $q->where(function ($qq) use ($term) {
                $qq->where('code', 'like', "%{$term}%")
                   ->orWhere('name', 'like', "%{$term}%")
                   ->orWhere('area', 'like', "%{$term}%");
            });
        }

        if (isset($filters['active'])) {
            // admite "1"/"0" o boolean
            $active = filter_var($filters['active'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if (!is_null($active)) {
                $q->where('active', $active);
            }
        }

        $q->latest('id');

        $perPage = (int)($filters['per_page'] ?? 10);
        if ($perPage > 0) {
            return $q->paginate($perPage);
        }
        return $q->get();
    }

    /** Crear línea */
    public function createLine(array $data): ProductionLine     
    {
        $data['active'] = $data['active'] ?? true;
        return ProductionLine::create($data);
    }

    /** Actualizar línea */
    public function updateLine(ProductionLine $line, array $data): ProductionLine
    {
        $line->update($data);
        return $line;
    }

    /** Eliminar línea */
    public function deleteLine(ProductionLine $line): void
    {
        $line->delete();
    }

    //** PRODUCTION LINES */
    public function listTools(array $filters = []): LengthAwarePaginator|Collection
    {
        $q = Tool::query()->with('line');

        if (!empty($filters['q'])) {
            $term = trim($filters['q']);
            $q->where(function ($qq) use ($term) {
                $qq->where('code', 'like', "%{$term}%")
                   ->orWhere('name', 'like', "%{$term}%")
                   ->orWhere('model', 'like', "%{$term}%");
            });
        }

        if (!empty($filters['line_id'])) {
            $q->where('line_id', (int)$filters['line_id']);
        }

        if (isset($filters['active'])) {
            $active = filter_var($filters['active'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if (!is_null($active)) {
                $q->where('active', $active);
            }
        }

        $q->latest('id');

        $perPage = (int)($filters['per_page'] ?? 10);
        return $perPage > 0 ? $q->paginate($perPage) : $q->get();
    }

    /** Crear Tool */
    public function createTool(array $data): Tool
    {
        $data['active'] = $data['active'] ?? true;
        return Tool::create($data);
    }

    /** Actualizar Tool */
    public function updateTool(Tool $tool, array $data): Tool
    {
        $tool->update($data);
        return $tool->load('line');
    }

    /** Eliminar Tool */
    public function deleteTool(Tool $tool): void
    {
        $tool->delete();
    }

}
