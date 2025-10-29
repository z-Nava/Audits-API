<?php

namespace App\Http\Controllers\Web\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginWebController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        // Puede ser email o número de empleado
        $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'employee_number';

        if (Auth::attempt([$field => $request->login, 'password' => $request->password, 'role' => 'supervisor', 'active' => true])) {
            $request->session()->regenerate();
            return redirect()->intended(route('supervisor.dashboard'));
        }

        return back()->withErrors([
            'login' => 'Credenciales inválidas o usuario inactivo.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

