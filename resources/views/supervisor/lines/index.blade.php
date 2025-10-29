@extends('layouts.supervisor')

@section('title', 'Líneas de Producción')

@section('content')
    <h1 class="text-xl font-bold mb-4">Líneas de Producción</h1>

    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Código</th>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Área</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lines as $line)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $line->id }}</td>
                    <td class="px-4 py-2">{{ $line->code }}</td>
                    <td class="px-4 py-2">{{ $line->name }}</td>
                    <td class="px-4 py-2">{{ $line->area }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
