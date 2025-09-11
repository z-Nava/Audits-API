<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\ProductionLine;
use App\Models\Tool;
use App\Models\Employee;
use App\Models\Assignment;
use App\Models\Audit;
use App\Models\AuditItem;
use App\Models\AuditPhoto;
use App\Models\AuditReview;


class AuditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Supervisor
        $supervisor = User::create([
            'name' => 'Supervisor Demo',
            'email' => 'supervisor@example.com',
            'password' => Hash::make('password'),
            'employee_number' => 'SUP1001',
            'role' => 'supervisor',
            'active' => true,
        ]);

        // 2. Técnico
        $technician = User::create([
            'name' => 'Technician Demo',
            'email' => 'technician@example.com',
            'password' => Hash::make('password'),
            'employee_number' => 'TEC2001',
            'role' => 'technician',
            'active' => true,
        ]);

        // 3. Línea de producción
        $line = ProductionLine::create([
            'code' => 'LINE-01',
            'name' => 'Línea de Ensamble A',
            'area' => 'Coating',
        ]);

        // 4. Herramientas
        $tool1 = Tool::create([
            'code' => 'TOOL-001',
            'name' => 'S12345',
            'model' => 'Modelo A',
            'description' => 'Herramienta para ajuste',
            'line_id' => $line->id,
        ]);

        $tool2 = Tool::create([
            'code' => 'TOOL-002',
            'name' => 'S12346',
            'model' => 'Modelo B',
            'description' => 'Herramienta de torque',
            'line_id' => $line->id,
        ]);

        // 5. Empleado (número de empleado válido)
        $employee = Employee::create([
            'employee_number' => 'EMP3001',
            'name' => 'Empleado de Planta',
            'registered_by' => $supervisor->id,
        ]);

        // 6. Asignación (supervisor → técnico)
        $assignment = Assignment::create([
            'supervisor_id' => $supervisor->id,
            'technician_id' => $technician->id,
            'line_id' => $line->id,
            'shift' => 'A',
            'status' => 'assigned',
            'assigned_at' => now(),
            'notes' => 'Revisión inicial de herramientas',
        ]);

        // Agregar herramientas a la asignación (N:M)
        $assignment->tools()->attach([$tool1->id, $tool2->id]);

        // 7. Auditoría creada por el técnico
        $audit = Audit::create([
            'assignment_id' => $assignment->id,
            'technician_id' => $technician->id,
            'supervisor_id' => $supervisor->id,
            'employee_number' => $employee->employee_number,
            'audit_code' => 'AUD-' . now()->format('Ymd') . '-' . Str::random(5),
            'line_id' => $line->id,
            'shift' => 'A',
            'status' => 'submitted',
            'summary' => 'Todo en orden, salvo detalle menor en TOOL-002',
            'overall_result' => 'FAIL',
            'started_at' => now()->subHour(),
            'ended_at' => now(),
        ]);

        // 8. Resultados por herramienta
        $item1 = AuditItem::create([
            'audit_id' => $audit->id,
            'tool_id' => $tool1->id,
            'result' => 'PASS',
            'comments' => 'Sin observaciones',
        ]);

        $item2 = AuditItem::create([
            'audit_id' => $audit->id,
            'tool_id' => $tool2->id,
            'result' => 'FAIL',
            'comments' => 'Defecto en torque',
        ]);

        // 9. Fotos de evidencia
        AuditPhoto::create([
            'audit_item_id' => $item2->id,
            'path' => 'photos/tool2_fail.jpg',
            'caption' => 'Foto del defecto de torque',
            'taken_at' => now(),
        ]);

        // 10. Revisión del supervisor
        AuditReview::create([
            'audit_id' => $audit->id,
            'supervisor_id' => $supervisor->id,
            'decision' => 'rejected',
            'notes' => 'Rehacer la auditoría con herramienta reparada',
            'reviewed_at' => now(),
        ]);
    }
}
