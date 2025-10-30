<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panel Supervisor')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-black text-white shadow-lg">
        <div class="container mx-auto px-6 py-3 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/MW-LOGO-WHITE.png') }}" alt="Logo MW" class="h-10">
                <span class="text-xl font-bold">Panel Supervisor</span>
            </div>

            <!-- Menu -->
            <ul class="flex space-x-6 text-sm font-semibold">
                <li><a href="{{ route('supervisor.dashboard') }}" class="hover:text-red-500">Dashboard</a></li>
                <li><a href="{{ route('supervisor.lines.index') }}" class="hover:text-red-500">Líneas</a></li>
                <li><a href="{{ route('supervisor.tools.index') }}" class="hover:text-red-500">Herramientas</a></li>
                <li><a href="{{ route('supervisor.technicians.index') }}" class="hover:text-red-500">Técnicos</a></li>
                <li><a href="{{ route('supervisor.assignments.index') }}" class="hover:text-red-500">Asignaciones</a></li>
                <li><a href="{{ route('supervisor.audits.index') }}" class="hover:text-red-500">Auditorías</a></li>
            </ul>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main class="container mx-auto px-6 py-8">
        @yield('content')
    </main>

    <!-- Footer opcional -->
    <footer class="text-center text-xs text-gray-500 py-4">
        &copy; {{ now()->year }} Milwaukee Tool — Supervisión de Calidad
    </footer>

</body>
</html>
