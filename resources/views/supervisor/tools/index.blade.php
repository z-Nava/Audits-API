@extends('layouts.supervisor')

@section('title', 'Herramientas')

@section('content')
    <h1 class="text-xl font-bold mb-4">Herramientas</h1>

    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Código</th>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Modelo</th>
                <th class="px-4 py-2">Línea</th>
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
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
