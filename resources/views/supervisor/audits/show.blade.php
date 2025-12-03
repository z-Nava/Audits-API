@extends('layouts.supervisor')

@section('title', 'Detalle auditoría')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Auditoría {{ $audit->audit_code }}</h1>

    <div class="mb-6 space-y-2 bg-white p-4 rounded shadow">
        <p><strong>Línea:</strong> {{ $audit->line->name ?? '—' }}</p>
        <p><strong>Técnico:</strong> {{ $audit->technician->name ?? '—' }}</p>
        <p><strong>Supervisor:</strong> {{ $audit->supervisor->name ?? '—' }}</p>
        <p><strong>Turno:</strong> {{ ucfirst($audit->shift) }}</p>
        <p><strong>Estado:</strong> {{ ucfirst($audit->status) }}</p>
        <p><strong>Resultado:</strong> {{ $audit->overall_result ?? '—' }}</p>
        <p><strong>Inicio:</strong> {{ $audit->started_at }}</p>
        <p><strong>Fin:</strong> {{ $audit->ended_at ?? '—' }}</p>
    </div>

    <h2 class="text-xl font-semibold mt-6 mb-2">Ítems auditados</h2>
    <table class="w-full bg-white shadow rounded mb-6">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="px-4 py-2">Herramienta</th>
                <th class="px-4 py-2">Resultado</th>
                <th class="px-4 py-2">Comentarios</th>
            </tr>
        </thead>
        <tbody>
    @foreach($audit->items as $item)
        <tr class="border-t align-top">
            <td class="px-4 py-2">{{ $item->tool->name ?? '—' }}</td>
            <td class="px-4 py-2">{{ $item->result }}</td>
            <td class="px-4 py-2 space-y-2">
                <p>{{ $item->comments ?? '—' }}</p>

                {{-- 📸 Mostrar fotos si existen --}}
                @if($item->photos && $item->photos->count() > 0)
                    <div class="flex flex-wrap gap-3 mt-2">
                        @foreach($item->photos as $photo)
                            <a href="{{ asset('storage/'.$photo->path) }}" 
                               target="_blank" 
                               class="block border rounded overflow-hidden shadow-md hover:ring-2 hover:ring-blue-500 transition">
                                <img src="{{ asset('storage/'.$photo->path) }}"
                                     alt="Foto auditoría"
                                     class="h-24 w-24 object-cover">
                            </a>
                        @endforeach
                    </div>
                @else
                    <span class="text-gray-500 italic">Sin evidencias</span>
                @endif

            </td>
        </tr>
    @endforeach
</tbody>

    </table>

    <h2 class="text-xl font-semibold mb-2">Revisiones</h2>
    @forelse($audit->reviews as $review)
        <div class="bg-gray-100 p-3 rounded mb-2">
            <p><strong>Decisión:</strong> {{ ucfirst($review->decision) }}</p>
            <p><strong>Supervisor:</strong> {{ $review->supervisor->name }}</p>
            <p><strong>Fecha:</strong> {{ $review->reviewed_at }}</p>
            <p><strong>Notas:</strong> {{ $review->notes ?? '—' }}</p>
        </div>
    @empty
        <p>No hay revisiones aún.</p>
    @endforelse

    {{-- Estado actual para debug --}}
    <pre>Estado actual: [{{ $audit->status }}]</pre>

    {{-- Formulario de revisión --}}
    @if($audit->status === 'submitted')
        <h2 class="text-xl font-semibold mb-2 mt-6">Revisar auditoría</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('supervisor.audits.review', $audit->id) }}" class="space-y-4 bg-white p-4 rounded shadow">
            @csrf
            <div>
                <label class="block mb-1 font-medium">Decisión</label>
                <select name="decision" required class="w-full border p-2 rounded">
                    <option value="">— Selecciona —</option>
                    <option value="approved">Aprobar</option>
                    <option value="needs_changes">Solicitar cambios</option>
                    <option value="rejected">Rechazar</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-medium">Notas (opcional)</label>
                <textarea name="notes" rows="3" class="w-full border p-2 rounded"></textarea>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Enviar revisión</button>
        </form>
    @endif

    {{-- Botón para reabrir --}}
    @if($audit->status === 'reviewed')
        <h2 class="text-xl font-semibold mb-2 mt-6">Reabrir auditoría</h2>
        <form method="POST" action="{{ route('supervisor.audits.reopen', $audit->id) }}"
              onsubmit="return confirm('¿Estás seguro que deseas reabrir esta auditoría?')"
              class="bg-white p-4 rounded shadow mt-4">
            @csrf
            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">
                Reabrir auditoría
            </button>
        </form>
    @endif

    {{-- Mensaje si ya está cerrada --}}
    @if($audit->status === 'closed')
        <div class="bg-gray-100 p-3 rounded mt-4">
            <p class="text-gray-700">Esta auditoría ha sido cerrada y no se pueden realizar más acciones.</p>
        </div>
    @endif
@endsection
