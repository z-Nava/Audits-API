@extends('layouts.supervisor')

@section('title', 'Crear herramienta')

@section('content')
    <h1 class="text-xl font-bold mb-4">Nueva herramienta</h1>

    <form method="POST" action="{{ route('supervisor.tools.store') }}" class="space-y-4">
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
            <label class="block">Modelo</label>
            <input type="text" name="model" class="w-full border p-2 rounded">
        </div>

        <div>
            <label class="block">Línea de producción</label>
            <select name="line_id" class="w-full border p-2 rounded">
                <option value="">— Ninguna —</option>
                @foreach($lines as $line)
                    <option value="{{ $line->id }}">{{ $line->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label><input type="checkbox" name="active" checked> Activa</label>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Guardar</button>
    </form>
@endsection
