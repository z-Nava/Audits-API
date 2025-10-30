@extends('layouts.supervisor')

@section('title', 'Asignaciones')

@section('content')
    <h1 class="text-xl font-bold mb-4">Asignaciones</h1>
    <a href="{{ route('supervisor.assignments.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
        + Crear asignación
    </a>
    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Técnico</th>
                <th class="px-4 py-2">Línea</th>
                <th class="px-4 py-2">Turno</th>
                <th class="px-4 py-2">Estado</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assignments as $a)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $a->id }}</td>
                    <td class="px-4 py-2">{{ $a->technician->name ?? '—' }}</td>
                    <td class="px-4 py-2">{{ $a->line->name ?? '—' }}</td>
                    <td class="px-4 py-2">{{ ucfirst($a->shift) }}</td>
                    <td class="px-4 py-2">{{ ucfirst($a->status) }}</td>
                    <td class="px-4 py-2 flex gap-2">
                        <a href="{{ route('supervisor.assignments.edit', $a->id) }}" class="text-blue-600">Editar</a>
                        <form action="{{ route('supervisor.assignments.destroy', $a->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta asignación?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
