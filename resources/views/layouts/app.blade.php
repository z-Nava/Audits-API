<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Panel Supervisor')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  {{-- Tailwind CDN --}}
  <script src="https://cdn.tailwindcss.com"></script>
  {{-- Fuente opcional --}}
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
</head>
<body class="bg-gray-50 text-gray-900">
  <header class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
      <div class="text-xl font-semibold">Audits Admin</div>
      <nav class="flex gap-4 text-sm">
        <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
        <a href="{{ route('assignments.index') }}" class="hover:underline">Asignaciones</a>
        <a href="{{ route('audits.index') }}" class="hover:underline">Auditorías</a>
      </nav>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="text-sm px-3 py-1.5 rounded bg-gray-900 text-white hover:bg-gray-700">Salir</button>
      </form>
    </div>
  </header>

  <main class="max-w-7xl mx-auto px-4 py-6">
    @if(session('ok'))
      <div class="mb-4 rounded bg-green-100 text-green-800 px-4 py-2">{{ session('ok') }}</div>
    @endif
    @if($errors->any())
      <div class="mb-4 rounded bg-red-100 text-red-800 px-4 py-2">
        <ul class="list-disc ml-5">
          @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
      </div>
    @endif

    @yield('content')
  </main>

  <footer class="max-w-7xl mx-auto px-4 py-6 text-xs text-gray-500">
    © {{ date('Y') }} Audits Admin
  </footer>
</body>
</html>
