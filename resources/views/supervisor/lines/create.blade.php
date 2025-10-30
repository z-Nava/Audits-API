@extends('layouts.supervisor')

@section('title', 'Crear línea')

@section('content')
    <h1 class="text-xl font-bold mb-4">Nueva línea de producción</h1>

    <form method="POST" action="{{ route('supervisor.lines.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block">Código</label>
            <input type="text" name="code" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block">Nombre</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block">Área</label>
            <input type="text" name="area" class="w-full border p-2 rounded">
        </div>

        <div>
            <label><input type="checkbox" name="active" value="1" checked> Activa</label>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Guardar</button>
    </form>
@endsection
