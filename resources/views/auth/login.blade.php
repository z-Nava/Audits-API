@extends('layouts.app')

@section('title','Iniciar sesión')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-xl shadow p-6">
  <h1 class="text-lg font-semibold mb-4">Iniciar sesión</h1>
  <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
    @csrf
    <div>
      <label class="block text-sm mb-1">Email</label>
      <input name="email" type="email" value="{{ old('email') }}" required class="w-full border rounded px-3 py-2">
    </div>
    <div>
      <label class="block text-sm mb-1">Password</label>
      <input name="password" type="password" required class="w-full border rounded px-3 py-2">
    </div>
    <div class="flex items-center justify-between">
      <label class="text-sm flex items-center gap-2">
        <input type="checkbox" name="remember" class="rounded"> Recordarme
      </label>
      <button class="px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-700">Entrar</button>
    </div>
  </form>
</div>
@endsection
