@extends('layouts.supervisor')

@section('title', 'Editar empleado')

@section('content')
    <h1 class="text-xl font-bold mb-4">Editar empleado: {{ $employee->name }}</h1>

    <form method="POST" action="{{ route('supervisor.employees.update', $employee->id) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block">Número de empleado</label>
            <input type="text" name="employee_number" value="{{ $employee->employee_number }}" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block">Nombre</label>
            <input type="text" name="name" value="{{ $employee->name }}" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label><input type="checkbox" name="active" {{ $employee->active ? 'checked' : '' }}> Activo</label>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
    </form>
@endsection
