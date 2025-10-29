<?php

namespace App\Http\Controllers\Web\Supervisor;

use App\Http\Controllers\Controller;
use App\Services\CatalogService;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class EmployeeWebController extends Controller
{
    protected CatalogService $catalog;

    public function __construct(CatalogService $catalog)
    {
        $this->catalog = $catalog;
    }

    public function index(Request $request)
    {
        $employees = $this->catalog->listEmployees(['per_page' => 100]);
        return view('supervisor.employees.index', compact('employees'));
    }

        public function create()
    {
        return view('supervisor.employees.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_number' => 'required|string|max:20|unique:employees',
            'name'            => 'required|string|max:100',
            'active'          => 'sometimes|boolean',
        ]);

        $data['registered_by'] = Auth::id();
        $this->catalog->createEmployee($data);

        return redirect()->route('supervisor.employees.index')->with('success', 'Empleado creado correctamente.');
    }

    public function edit(Employee $employee)
    {
        return view('supervisor.employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'employee_number' => 'required|string|max:20|unique:employees,employee_number,' . $employee->id,
            'name'            => 'required|string|max:100',
            'active'          => 'sometimes|boolean',
        ]);

        $this->catalog->updateEmployee($employee, $data);

        return redirect()->route('supervisor.employees.index')->with('success', 'Empleado actualizado.');
    }

    public function destroy(Employee $employee)
    {
        $this->catalog->deleteEmployee($employee);

        return redirect()->route('supervisor.employees.index')->with('success', 'Empleado eliminado.');
    }
}
