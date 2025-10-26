@extends('layouts.app')
@section('title','Auditorías')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Auditorías</h1>

<form method="GET" class="bg-white rounded-xl shadow p-4 mb-4 grid md:grid-cols-5 gap-3">
  <select name="status" class="border rounded px-3 py-2">
    <option value="">Estado</option>
    @foreach(['in_progress','submitted','reviewed','closed'] as $s)
      <option value="{{ $s }}" @selected(($filters['status'] ?? '')==$s)>{{ $s }}</option>
    @endforeach
  </select>
  <select name="result" class="border rounded px-3 py-2">
    <option value="">Resultado</option>
    @foreach(['PASS','FAIL'] as $r)
      <option value="{{ $r }}" @selected(($filters['result'] ?? '')==$r)>{{ $r }}</option>
    @endforeach
  </select>
  <input type="date" name="from" value="{{ $filters['from'] ?? '' }}" class="border rounded px-3 py-2">
  <input type="date" name="to" value="{{ $filters['to'] ?? '' }}" class="border rounded px-3 py-2">
  <div class="md:col-span-1">
    <button class="w-full px-4 py-2 bg-gray-900 text-white rounded">Filtrar</button>
  </div>
</form>

<div class="bg-white rounded-xl shadow overflow-hidden">
  <table class="w-full text-sm">
    <thead class="bg-gray-50">
      <tr>
        <th class="text-left p-3">Código</th>
        <th class="text-left p-3">Técnico</th>
        <th class="text-left p-3">Línea</th>
        <th class="text-left p-3">Estado</th>
        <th class="text-left p-3">Resultado</th>
        <th class="text-right p-3">Acciones</th>
      </tr>
    </thead>
    <tbody class="divide-y">
      @foreach($items as $a)
        <tr>
          <td class="p-3">{{ $a->audit_code }}</td>
          <td class="p-3">{{ $a->technician->name ?? '-' }}</td>
          <td class="p-3">{{ $a->line->code ?? '-' }}</td>
          <td class="p-3">{{ $a->status }}</td>
          <td class="p-3">{{ $a->overall_result ?? '—' }}</td>
          <td class="p-3 text-right">
            <a href="{{ route('audits.show',$a->id) }}" class="text-blue-600 hover:underline">Ver</a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="mt-4">
  @if(method_exists($items,'links'))
    {{ $items->links() }}
  @endif
</div>
@endsection
