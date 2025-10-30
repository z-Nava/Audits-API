@extends('layouts.supervisor')

@section('title', 'Herramientas')

@section('content')
    <h1 class="text-xl font-bold mb-4">Herramientas</h1>
    <a href="{{ route('supervisor.tools.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
        + Crear herramienta
    </a>
    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Código</th>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Modelo</th>
                <th class="px-4 py-2">Línea</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tools as $tool)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $tool->id }}</td>
                    <td class="px-4 py-2">{{ $tool->code }}</td>
                    <td class="px-4 py-2">{{ $tool->name }}</td>
                    <td class="px-4 py-2">{{ $tool->model }}</td>
                    <td class="px-4 py-2">{{ $tool->line->name ?? '—' }}</td>
                    <td class="px-4 py-2 flex gap-2">
                        <a href="{{ route('supervisor.tools.edit', $tool->id) }}" class="text-blue-600">Editar</a>
                        <form action="{{ route('supervisor.tools.destroy', $tool->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta herramienta?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
