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
                <th class="px-4 py-2">Acciones</th>
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
                    <td class="px-4 py-2 flex gap-2">
                        <a href="{{ route('supervisor.employees.edit', $employee->id) }}" class="text-blue-600">Editar</a>
                        <form action="{{ route('supervisor.employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este empleado?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
