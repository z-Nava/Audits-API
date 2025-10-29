@extends('layouts.supervisor')

@section('title', 'Asignaciones')

@section('content')
    <h1 class="text-xl font-bold mb-4">Asignaciones</h1>

    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Técnico</th>
                <th class="px-4 py-2">Línea</th>
                <th class="px-4 py-2">Turno</th>
                <th class="px-4 py-2">Estado</th>
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
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
