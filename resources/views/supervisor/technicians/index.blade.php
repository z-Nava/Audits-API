@extends('layouts.supervisor')

@section('title', 'Técnicos')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Técnicos registrados</h1>

    <a href="{{ route('supervisor.technicians.create') }}" class="bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">Nuevo técnico</a>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Número de empleado</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($technicians as $technician)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $technician->name }}</td>
                    <td class="px-4 py-2">{{ $technician->employee_number }}</td>
                    <td class="px-4 py-2">{{ $technician->email ?? '—' }}</td>
                    <td class="px-4 py-2">
                        <form method="POST" action="{{ route('supervisor.technicians.destroy', $technician->id) }}" onsubmit="return confirm('¿Eliminar técnico?');">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Eliminar</button>
                        </form>
                        <a href="{{ route('supervisor.technicians.edit', $technician->id) }}" class="text-blue-600 hover:underline">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
