@extends('layouts.supervisor')

@section('title', 'Empleados')

@section('content')
    <h1 class="text-xl font-bold mb-4">Empleados</h1>

    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Número</th>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Activo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $employee->id }}</td>
                    <td class="px-4 py-2">{{ $employee->employee_number }}</td>
                    <td class="px-4 py-2">{{ $employee->name }}</td>
                    <td class="px-4 py-2">
                        @if($employee->active)
                            <span class="text-green-600 font-semibold">Sí</span>
                        @else
                            <span class="text-red-600 font-semibold">No</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
