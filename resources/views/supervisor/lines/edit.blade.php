@extends('layouts.supervisor')

@section('title', 'Editar línea')

@section('content')
    <h1 class="text-xl font-bold mb-4">Editar línea: {{ $line->name }}</h1>

    <form method="POST" action="{{ route('supervisor.lines.update', $line->id) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block">Código</label>
            <input type="text" name="code" value="{{ $line->code }}" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block">Nombre</label>
            <input type="text" name="name" value="{{ $line->name }}" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block">Área</label>
            <input type="text" name="area" value="{{ $line->area }}" class="w-full border p-2 rounded">
        </div>

        <div>
            <label><input type="checkbox" name="active" {{ $line->active ? 'checked' : '' }}> Activa</label>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
    </form>
@endsection
