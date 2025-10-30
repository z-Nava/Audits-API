@extends('layouts.supervisor')

@section('title', 'Editar técnico')

@section('content')
<h1 class="text-2xl font-bold mb-4">Editar Técnico</h1>

@if ($errors->any())
    <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
        <ul class="list-disc pl-4">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('supervisor.technicians.update', $technician->id) }}" method="POST" class="bg-white p-6 rounded shadow-md space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block mb-1 font-medium">Nombre</label>
        <input type="text" name="name" value="{{ old('name', $technician->name) }}" class="w-full border p-2 rounded" required>
    </div>

    <div>
        <label class="block mb-1 font-medium">Email</label>
        <input type="email" name="email" value="{{ old('email', $technician->email) }}" class="w-full border p-2 rounded" required>
    </div>

    <div>
        <label class="block mb-1 font-medium">Número de empleado</label>
        <input type="text" name="employee_number" value="{{ old('employee_number', $technician->employee_number) }}" class="w-full border p-2 rounded" required>
    </div>

    <div>
        <label class="block mb-1 font-medium">Activo</label>
        <select name="active" class="w-full border p-2 rounded" required>
            <option value="1" {{ old('active', $technician->active) ? 'selected' : '' }}>Sí</option>
            <option value="0" {{ !old('active', $technician->active) ? 'selected' : '' }}>No</option>
        </select>
    </div>

    <div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
        <a href="{{ route('supervisor.technicians.index') }}" class="ml-4 text-gray-600 underline">Cancelar</a>
    </div>
</form>
@endsection
