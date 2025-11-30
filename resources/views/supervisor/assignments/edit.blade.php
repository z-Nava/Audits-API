@extends('layouts.supervisor')

@section('title', 'Editar asignación')

@section('content')
<h1 class="text-xl font-bold mb-4">Editar asignación</h1>

<form method="POST" action="{{ route('supervisor.assignments.update', $assignment->id) }}" class="space-y-4">
    @csrf
    @method('PUT')

    {{-- Técnico --}}
    <div>
        <label class="block">Técnico</label>
        <select name="technician_id" required class="w-full border p-2 rounded">
            @foreach($technicians as $t)
                <option value="{{ $t->id }}" {{ $assignment->technician_id == $t->id ? 'selected' : '' }}>
                    {{ $t->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Línea --}}
    <div>
        <label class="block">Línea</label>
        <select name="line_id" required class="w-full border p-2 rounded"
                onchange="window.location='?line_id='+this.value">
            @foreach($lines as $line)
                <option value="{{ $line->id }}"
                    {{ request('line_id', $assignment->line_id) == $line->id ? 'selected' : '' }}>
                    {{ $line->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Herramientas --}}
    @php
        $selectedLine = request('line_id', $assignment->line_id);
        $tools = \App\Models\Tool::where('line_id', $selectedLine)->active()->get();
        $toolsSelected = $assignment->tools()->pluck('tools.id')->toArray();
    @endphp

    <div>
        <label class="block">Herramientas</label>
        <div class="grid grid-cols-2 gap-2">
            @foreach($tools as $tool)
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="tools[]"
                        value="{{ $tool->id }}"
                        {{ in_array($tool->id, $toolsSelected) ? 'checked' : '' }}>
                    {{ $tool->name }}
                </label>
            @endforeach
        </div>
    </div>

    {{-- Turno --}}
    <div>
        <label class="block">Turno</label>
        <select name="shift" class="w-full border p-2 rounded" required>
            <option value="A" {{ $assignment->shift === 'A' ? 'selected' : '' }}>Mañana</option>
            <option value="B" {{ $assignment->shift === 'B' ? 'selected' : '' }}>Tarde</option>
            <option value="C" {{ $assignment->shift === 'C' ? 'selected' : '' }}>Noche</option>
        </select>
    </div>

    {{-- Fechas --}}
    <div>
        <label class="block">Fecha asignación</label>
        <input type="date" name="assigned_at"
            value="{{ \Carbon\Carbon::parse($assignment->assigned_at)->toDateString() }}"
            class="w-full border p-2 rounded" required>
    </div>

    <div>
        <label class="block">Fecha límite</label>
        <input type="date" name="due_at"
            value="{{ optional($assignment->due_at)->toDateString() }}"
            class="w-full border p-2 rounded">
    </div>

    {{-- Notas --}}
    <div>
        <label class="block">Notas</label>
        <textarea name="notes" class="w-full border p-2 rounded">{{ $assignment->notes }}</textarea>
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
</form>

@endsection
