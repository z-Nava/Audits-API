@extends('layouts.supervisor')

@section('title', 'Nuevo empleado')

@section('content')
    <h1 class="text-xl font-bold mb-4">Registrar nuevo empleado</h1>

    <form method="POST" action="{{ route('supervisor.employees.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block">Número de empleado</label>
            <input type="text" name="employee_number" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block">Nombre</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label><input type="checkbox" name="active" checked> Activo</label>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Guardar</button>
    </form>
@endsection
