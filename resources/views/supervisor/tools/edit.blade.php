@extends('layouts.supervisor')

@section('title', 'Editar herramienta')

@section('content')
    <h1 class="text-xl font-bold mb-4">Editar herramienta: {{ $tool->name }}</h1>

    <form method="POST" action="{{ route('supervisor.tools.update', $tool->id) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block">Código</label>
            <input type="text" name="code" value="{{ $tool->code }}" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block">Nombre</label>
            <input type="text" name="name" value="{{ $tool->name }}" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block">Modelo</label>
            <input type="text" name="model" value="{{ $tool->model }}" class="w-full border p-2 rounded">
        </div>

        <div>
            <label class="block">Línea de producción</label>
            <select name="line_id" class="w-full border p-2 rounded">
                <option value="">— Ninguna —</option>
                @foreach($lines as $line)
                    <option value="{{ $line->id }}" {{ $tool->line_id == $line->id ? 'selected' : '' }}>
                        {{ $line->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <input type="hidden" name="active" value="0">

            <label>
                <input type="checkbox" name="active" value="1" {{ old('active', $tool->active ?? true) ? 'checked' : '' }}>
                Activa
            </label>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
    </form>
@endsection
