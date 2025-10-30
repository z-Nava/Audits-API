<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Supervisor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Fondo animado estilo lava */
        @keyframes backgroundSlide {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        body {
            background: linear-gradient(-45deg, #000000, #8b0000, #801c1cff, #000000);
            background-size: 400% 400%;
            animation: backgroundSlide 15s ease infinite;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen text-white px-4">
    <div class="bg-white bg-opacity-10 backdrop-blur-md p-8 rounded-lg shadow-lg w-full max-w-sm border border-white/20">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/MW-LOGO-WHITE.png') }}" alt="Logo Milwaukee" class="h-16">
        </div>

        <h1 class="text-2xl font-bold mb-4 text-center text-white">Login Supervisor</h1>

        @if($errors->any())
            <div class="bg-red-500/70 text-white p-3 mb-4 rounded text-sm shadow">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label class="block mb-2 text-sm font-semibold">Correo o Nº Empleado</label>
            <input type="text" name="login" required
                   class="w-full px-4 py-2 mb-4 rounded bg-white text-black focus:outline-none focus:ring-2 focus:ring-red-600">

            <label class="block mb-2 text-sm font-semibold">Contraseña</label>
            <input type="password" name="password" required
                   class="w-full px-4 py-2 mb-6 rounded bg-white text-black focus:outline-none focus:ring-2 focus:ring-red-600">

            <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 rounded transition">
                Iniciar sesión
            </button>
        </form>
    </div>
</body>
</html>
