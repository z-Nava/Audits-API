@extends('layouts.app')
@section('title','Asignación #'.$assignment->id)

@section('content')
<h1 class="text-2xl font-semibold mb-4">Asignación #{{ $assignment->id }}</h1>

<div class="grid md:grid-cols-2 gap-4">
  <div class="bg-white rounded-xl shadow p-4">
    <div class="text-sm text-gray-500">Supervisor</div>
    <div class="font-medium">{{ $assignment->supervisor->name ?? '-' }}</div>
    <div class="text-sm text-gray-500 mt-3">Técnico</div>
    <div class="font-medium">{{ $assignment->technician->name ?? '-' }}</div>
    <div class="text-sm text-gray-500 mt-3">Línea</div>
    <div class="font-medium">{{ $assignment->line->code ?? '-' }}</div>
    <div class="text-sm text-gray-500 mt-3">Turno</div>
    <div class="font-medium">{{ $assignment->shift }}</div>
  </div>

  <div class="bg-white rounded-xl shadow p-4">
    <div class="text-sm text-gray-500">Estado actual</div>
    <div class="font-medium mb-4">{{ $assignment->status }}</div>
    <form method="POST" action="{{ route('assignments.status',$assignment->id) }}" class="flex gap-2">
      @csrf @method('PATCH')
      <select name="status" class="border rounded px-3 py-2">
        @foreach(['assigned','in_progress','completed','cancelled'] as $s)
          <option value="{{ $s }}">{{ $s }}</option>
        @endforeach
      </select>
      <button class="px-3 py-2 bg-gray-900 text-white rounded">Cambiar</button>
    </form>
  </div>
</div>

<div class="bg-white rounded-xl shadow mt-6">
  <div class="px-4 py-3 border-b font-medium">Herramientas</div>
  <div class="divide-y">
    @forelse($assignment->tools as $t)
      <div class="px-4 py-3 flex justify-between">
        <div>{{ $t->code }} — {{ $t->name }} ({{ $t->model }})</div>
      </div>
    @empty
      <div class="px-4 py-6 text-sm text-gray-500">Sin herramientas adjuntas.</div>
    @endforelse
  </div>
</div>
@endsection
