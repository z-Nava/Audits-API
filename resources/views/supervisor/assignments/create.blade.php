@extends('layouts.supervisor')

@section('title', 'Nueva asignación')

@section('content')
<h1 class="text-xl font-bold mb-4">Nueva asignación</h1>

<form method="POST" action="{{ route('supervisor.assignments.store') }}" class="space-y-4">
@csrf

    <div>
        <label class="block">Técnico</label>
        <select name="technician_id" required class="w-full border p-2 rounded">
            @foreach($technicians as $t)
                <option value="{{ $t->id }}">{{ $t->name }} ({{ $t->email }})</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block">Línea</label>
        <select name="line_id" required class="w-full border p-2 rounded"
                onchange="this.form.submit()">
            <option value="">Seleccione...</option>
            @foreach($lines as $line)
                <option value="{{ $line->id }}" {{ old('line_id') == $line->id ? 'selected' : '' }}>
                    {{ $line->name }}
                </option>
            @endforeach
        </select>
    </div>

    @if(old('line_id'))
        @php
            $tools = \App\Models\Tool::where('line_id', old('line_id'))
                ->where('active', true)
                ->get();
        @endphp

        <div>
            <label class="block">Herramientas a auditar</label>
            <div class="grid grid-cols-2 gap-2">
                @foreach($tools as $tool)
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="tools[]" value="{{ $tool->id }}">
                        {{ $tool->name }}
                    </label>
                @endforeach
            </div>
        </div>
    @endif

    <div>
        <label class="block">Turno</label>
        <select name="shift" class="w-full border p-2 rounded" required>
            <option value="A">Mañana</option>
            <option value="B">Tarde</option>
            <option value="C">Noche</option>
        </select>
    </div>

    <div>
        <label class="block">Fecha asignación</label>
        <input type="date" name="assigned_at" required class="w-full border p-2 rounded">
    </div>

    <div>
        <label class="block">Fecha límite</label>
        <input type="date" name="due_at" class="w-full border p-2 rounded">
    </div>

    <div>
        <label class="block">Notas</label>
        <textarea name="notes" class="w-full border p-2 rounded"></textarea>
    </div>

    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Guardar</button>
</form>
@endsection
