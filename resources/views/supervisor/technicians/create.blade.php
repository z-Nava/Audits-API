@extends('layouts.supervisor')

@section('title', 'Registrar Técnico')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Registrar Técnico</h1>

    <form method="POST" action="{{ route('supervisor.technicians.store') }}" class="space-y-4 bg-white p-4 rounded shadow">
        @csrf

        <div>
            <label class="block font-medium">Nombre</label>
            <input type="text" name="name" required class="w-full border p-2 rounded" value="{{ old('name') }}">
        </div>

        <div>
            <label class="block font-medium">Número de empleado</label>
            <input type="text" name="employee_number" required class="w-full border p-2 rounded" value="{{ old('employee_number') }}">
        </div>

        <div>
            <label class="block font-medium">Correo electrónico (opcional)</label>
            <input type="email" name="email" class="w-full border p-2 rounded" value="{{ old('email') }}">
        </div>

        <div>
            <label class="block font-medium">Contraseña</label>
            <input type="password" name="password" required class="w-full border p-2 rounded">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar técnico</button>
    </form>
@endsection
