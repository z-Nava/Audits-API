<?php

namespace App\Http\Controllers;

use App\Services\CatalogService;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEmployeeRequest;
use App\Models\Employee;
use App\Http\Requests\UpdateEmployeeRequest;

class EmployeeController extends Controller
{
    public function __construct(private CatalogService $catalog){}

    public function index(Request $request)
    {
       $employees = $this->catalog->listEmployees($request->all());
        return response()->json($employees, 200);
    }

    public function store(StoreEmployeeRequest $request)
    {
        $employee = $this->catalog->createEmployee($request->validated());
        return response()->json($employee, 201);
    }

    public function show(Employee $employee)
    {
        return response()->json($employee->load('registeredBy:id,name,email'), 200);
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee = $this->catalog->updateEmployee($employee, $request->validated());
        return response()->json($employee, 200);
    }

    public function destroy(Employee $employee)
    {
        $this->catalog->deleteEmployee($employee);
        return response()->json(null, 204);
    }

    public function validateNumber(Request $request)
    {
        $request->validate([
            'employee_number' => 'required|string|max:5|unique:employees,employee_number',
        ]);

        $ok = $this->catalog->validateEmployeeNumber($request->employee_number);

        return response()->json(['message' => 'Employee number is valid and unique.',
                                'valid' => $ok
                             ], 200);
    }
}
