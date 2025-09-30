<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        // Por defecto todos los registros públicos son "technician" y activos
        $user = User::create([
            'name'            => $data['name'],
            'email'           => $data['email'],
            'password'        => Hash::make($data['password']),
            'employee_number' => $data['employee_number'] ?? null,
            'role'            => 'technician',
            'active'          => true,
        ]);

        // Abilities según rol
        $abilities = ['audits:*','catalog:read'];

        $token = $user->createToken('api', $abilities)->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role,
            ],
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Credenciales inválidas'], 422);
        }

        if (! $user->active) {
            return response()->json(['message' => 'Usuario inactivo'], 403);
        }

        // Abilities según rol
        $abilities = match ($user->role) {
            'admin'      => ['*'],
            'supervisor' => ['assignments:*','reviews:*','catalog:read','catalog:write','audits:read'],
            'technician' => ['audits:*','catalog:read'],
            default      => ['catalog:read'],
        };

        $device = $data['device_name'] ?? 'api';
        $token  = $user->createToken($device, $abilities)->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role,
            ],
        ], 200);
    }

    /** POST /api/v1/auth/logout */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();
        return response()->json(['message' => 'Sesión cerrada'], 200);
    }

    /** GET /api/v1/auth/me */
    public function me(Request $request)
    {
        $u = $request->user();

        return response()->json([
            'id'    => $u->id,
            'name'  => $u->name,
            'email' => $u->email,
            'role'  => $u->role,
        ], 200);
    }
}
