@extends('layouts.supervisor')

@section('title', 'Líneas de Producción')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-black">Líneas de Producción</h1>
        <a href="{{ route('supervisor.lines.create') }}"
           class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow transition">
            + Crear línea
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded shadow">
            <thead class="bg-black text-white">
                <tr>
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Código</th>
                    <th class="px-4 py-2 text-left">Nombre</th>
                    <th class="px-4 py-2 text-left">Área</th>
                    <th class="px-4 py-2 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lines as $line)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $line->id }}</td>
                        <td class="px-4 py-2">{{ $line->code }}</td>
                        <td class="px-4 py-2">{{ $line->name }}</td>
                        <td class="px-4 py-2">{{ $line->area ?? '—' }}</td>
                        <td class="px-4 py-2 flex gap-2">
                            <a href="{{ route('supervisor.lines.edit', $line->id) }}"
                               class="text-blue-600 hover:underline">Editar</a>
                            <form action="{{ route('supervisor.lines.destroy', $line->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('¿Eliminar esta línea?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">No hay líneas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
