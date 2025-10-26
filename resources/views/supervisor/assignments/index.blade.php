@extends('layouts.app')
@section('title','Asignaciones')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Asignaciones</h1>

<form method="GET" class="bg-white rounded-xl shadow p-4 mb-4 grid md:grid-cols-5 gap-3">
  <input name="technician_id" value="{{ $filters['technician_id'] ?? '' }}" class="border rounded px-3 py-2" placeholder="Technician ID">
  <input name="line_id" value="{{ $filters['line_id'] ?? '' }}" class="border rounded px-3 py-2" placeholder="Line ID">
  <select name="status" class="border rounded px-3 py-2">
    <option value="">Status</option>
    @foreach(['assigned','in_progress','completed','cancelled'] as $s)
      <option value="{{ $s }}" @selected(($filters['status'] ?? '')==$s)>{{ $s }}</option>
    @endforeach
  </select>
  <input type="date" name="from" value="{{ $filters['from'] ?? '' }}" class="border rounded px-3 py-2">
  <input type="date" name="to" value="{{ $filters['to'] ?? '' }}" class="border rounded px-3 py-2">
  <div class="md:col-span-5 text-right">
    <button class="px-4 py-2 bg-gray-900 text-white rounded">Filtrar</button>
  </div>
</form>

<div class="bg-white rounded-xl shadow overflow-hidden">
  <table class="w-full text-sm">
    <thead class="bg-gray-50">
      <tr>
        <th class="text-left p-3">ID</th>
        <th class="text-left p-3">Supervisor</th>
        <th class="text-left p-3">Técnico</th>
        <th class="text-left p-3">Línea</th>
        <th class="text-left p-3">Turno</th>
        <th class="text-left p-3">Estado</th>
        <th class="text-right p-3">Acciones</th>
      </tr>
    </thead>
    <tbody class="divide-y">
      @foreach($assignments as $a)
        <tr>
          <td class="p-3">{{ $a->id }}</td>
          <td class="p-3">{{ $a->supervisor->name ?? '-' }}</td>
          <td class="p-3">{{ $a->technician->name ?? '-' }}</td>
          <td class="p-3">{{ $a->line->code ?? '-' }}</td>
          <td class="p-3">{{ $a->shift }}</td>
          <td class="p-3">{{ $a->status }}</td>
          <td class="p-3 text-right">
            <a href="{{ route('assignments.show',$a->id) }}" class="text-blue-600 hover:underline">Ver</a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="mt-4">
  @if(method_exists($assignments,'links'))
    {{ $assignments->links() }}
  @endif
</div>
@endsection
