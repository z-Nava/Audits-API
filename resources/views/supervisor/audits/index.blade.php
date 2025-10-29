@extends('layouts.supervisor')

@section('title', 'Auditorías')

@section('content')
    <h1 class="text-xl font-bold mb-4">Auditorías</h1>

    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Código</th>
                <th class="px-4 py-2">Línea</th>
                <th class="px-4 py-2">Resultado</th>
                <th class="px-4 py-2">Estado</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($audits as $audit)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $audit->id }}</td>
                    <td class="px-4 py-2">{{ $audit->audit_code }}</td>
                    <td class="px-4 py-2">{{ $audit->line->name ?? '—' }}</td>
                    <td class="px-4 py-2">{{ $audit->overall_result ?? '—' }}</td>
                    <td class="px-4 py-2">{{ ucfirst($audit->status) }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('supervisor.audits.show', $audit->id) }}" class="text-blue-600 hover:underline">
                            Ver detalle
                        </a>
                </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
