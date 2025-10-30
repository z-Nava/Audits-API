<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panel Supervisor')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 p-6">
    <nav class="mb-6">
        <ul class="flex gap-4 text-blue-600 font-semibold">
            <li><a href="{{ route('supervisor.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('supervisor.lines.index') }}">Líneas</a></li>
            <li><a href="{{ route('supervisor.tools.index') }}">Herramientas</a></li>
            <li><a href="{{ route('supervisor.technicians.index') }}">Tecnicos de calidad</a></li>
            <li><a href="{{ route('supervisor.assignments.index') }}">Asignaciones</a></li>
            <li><a href="{{ route('supervisor.audits.index') }}">Auditorías</a></li>
        </ul>
    </nav>

    <main>
        @yield('content')
    </main>
</body>
</html>
