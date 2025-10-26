@extends('layouts.app')
@section('title','Auditoría '.$audit->audit_code)

@section('content')
<h1 class="text-2xl font-semibold mb-4">Auditoría {{ $audit->audit_code }}</h1>

<div class="grid md:grid-cols-3 gap-4">
  <div class="bg-white rounded-xl shadow p-4 md:col-span-2">
    <div class="text-sm text-gray-500">Resumen</div>
    <div class="mb-4">{{ $audit->summary ?? '—' }}</div>

    <div class="text-sm text-gray-500">Ítems</div>
    <div class="divide-y mt-2">
      @forelse($audit->items as $item)
        <div class="py-3">
          <div class="font-medium">{{ $item->tool->code }} — {{ $item->tool->name }}</div>
          <div class="text-sm">Resultado: <span class="font-semibold">{{ $item->result }}</span></div>
          <div class="text-sm text-gray-600">Comentarios: {{ $item->comments ?? '—' }}</div>
        </div>
      @empty
        <div class="py-6 text-sm text-gray-500">Sin ítems.</div>
      @endforelse
    </div>
  </div>

  <div class="bg-white rounded-xl shadow p-4">
    <div class="text-sm text-gray-500">Estado</div>
    <div class="font-medium mb-2">{{ $audit->status }}</div>
    <div class="text-sm text-gray-500">Resultado</div>
    <div class="font-medium mb-4">{{ $audit->overall_result ?? '—' }}</div>

    @if($audit->status === 'submitted')
      <form method="POST" action="{{ route('audits.review',$audit->id) }}" class="space-y-3">
        @csrf
        <input type="hidden" name="supervisor_id" value="{{ auth()->id() }}">
        <label class="block text-sm">Decisión</label>
        <select name="decision" class="w-full border rounded px-3 py-2">
          <option value="approved">Aprobar</option>
          <option value="needs_changes">Pedir cambios</option>
          <option value="rejected">Rechazar</option>
        </select>
        <label class="block text-sm">Notas</label>
        <textarea name="notes" class="w-full border rounded px-3 py-2" rows="3"></textarea>
        <button class="w-full px-4 py-2 bg-gray-900 text-white rounded">Enviar revisión</button>
      </form>
    @elseif($audit->status === 'reviewed')
      <form method="POST" action="{{ route('audits.reopen',$audit->id) }}" class="mt-3">
        @csrf
        <button class="w-full px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-500">Reabrir para cambios</button>
      </form>
    @endif

    <div class="mt-6">
      <div class="text-sm text-gray-500 mb-2">Historial de revisiones</div>
      <div class="space-y-2">
        @forelse($audit->reviews as $r)
          <div class="p-3 border rounded">
            <div class="text-sm">{{ $r->decision }} · {{ $r->reviewed_at }}</div>
            <div class="text-xs text-gray-500">Supervisor: {{ $r->supervisor->name ?? '-' }}</div>
            <div class="text-sm mt-1">{{ $r->notes ?? '—' }}</div>
          </div>
        @empty
          <div class="text-sm text-gray-500">Sin revisiones.</div>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection
