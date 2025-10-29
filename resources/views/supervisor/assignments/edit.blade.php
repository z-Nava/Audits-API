@extends('layouts.supervisor')

@section('title', 'Editar asignación')

@section('content')
    <h1 class="text-xl font-bold mb-4">Editar asignación</h1>

    <form method="POST" action="{{ route('supervisor.assignments.update', $assignment->id) }}" class="space-y-4">
        @csrf
        @method('PUT')

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

        <div>
            <label class="block">Línea</label>
            <select name="line_id" required class="w-full border p-2 rounded">
                @foreach($lines as $line)
                    <option value="{{ $line->id }}" {{ $assignment->line_id == $line->id ? 'selected' : '' }}>
                        {{ $line->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block">Turno</label>
            <select name="shift" class="w-full border p-2 rounded" required>
                <option value="morning" {{ $assignment->shift === 'morning' ? 'selected' : '' }}>Mañana</option>
                <option value="evening" {{ $assignment->shift === 'evening' ? 'selected' : '' }}>Tarde</option>
                <option value="night"   {{ $assignment->shift === 'night'   ? 'selected' : '' }}>Noche</option>
            </select>
        </div>

        <div>
            <label class="block">Fecha asignación</label>
            <input type="date" name="assigned_at" value="{{ \Illuminate\Support\Carbon::parse($assignment->assigned_at)->toDateString() }}" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block">Fecha límite</label>
            <input type="date" name="due_at" value="{{ optional($assignment->due_at)->toDateString() }}" class="w-full border p-2 rounded">
        </div>

        <div>
            <label class="block">Notas</label>
            <textarea name="notes" class="w-full border p-2 rounded">{{ $assignment->notes }}</textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
    </form>
@endsection
