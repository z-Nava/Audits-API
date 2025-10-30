@extends('layouts.supervisor')

@section('title', 'Líneas de Producción')

@section('content')
    <h1 class="text-xl font-bold mb-4">Líneas de Producción</h1>
 <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Líneas</h1>
        <a href="{{ route('supervisor.lines.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Crear línea</a>
    </div>
    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Código</th>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Área</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lines as $line)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $line->id }}</td>
                    <td class="px-4 py-2">{{ $line->code }}</td>
                    <td class="px-4 py-2">{{ $line->name }}</td>
                    <td class="px-4 py-2">{{ $line->area }}</td>
                    <td class="px-4 py-2 flex gap-2">
                        <a href="{{ route('supervisor.lines.edit', $line->id) }}" class="text-blue-600">Editar</a>
                        <form action="{{ route('supervisor.lines.destroy', $line->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta línea?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
