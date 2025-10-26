@extends('layouts.app')
@section('title','Dashboard')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Dashboard</h1>

<div class="grid md:grid-cols-4 gap-4 mb-8">
  <div class="bg-white rounded-xl shadow p-4">
    <div class="text-sm text-gray-500">Asignadas</div>
    <div class="text-2xl font-bold">{{ $assigned }}</div>
  </div>
  <div class="bg-white rounded-xl shadow p-4">
    <div class="text-sm text-gray-500">En progreso</div>
    <div class="text-2xl font-bold">{{ $inProgress }}</div>
  </div>
  <div class="bg-white rounded-xl shadow p-4">
    <div class="text-sm text-gray-500">Enviadas</div>
    <div class="text-2xl font-bold">{{ $submitted }}</div>
  </div>
  <div class="bg-white rounded-xl shadow p-4">
    <div class="text-sm text-gray-500">Cerradas</div>
    <div class="text-2xl font-bold">{{ $closed }}</div>
  </div>
</div>

<div class="bg-white rounded-xl shadow">
  <div class="px-4 py-3 border-b font-medium">Últimas auditorías</div>
  <div class="divide-y">
    @forelse($latestAudits as $a)
      <a href="{{ route('audits.show',$a->id) }}" class="block px-4 py-3 hover:bg-gray-50">
        <div class="flex items-center justify-between">
          <div>
            <div class="font-medium">{{ $a->audit_code }}</div>
            <div class="text-xs text-gray-500">
              Línea: {{ $a->line->code ?? '-' }} · Técnico: {{ $a->technician->name ?? '-' }} · Estado: {{ $a->status }}
            </div>
          </div>
          <div class="text-sm">{{ $a->overall_result ?? '—' }}</div>
        </div>
      </a>
    @empty
      <div class="px-4 py-6 text-sm text-gray-500">Sin auditorías recientes.</div>
    @endforelse
  </div>
</div>
@endsection
