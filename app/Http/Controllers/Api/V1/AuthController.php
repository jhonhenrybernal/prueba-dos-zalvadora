<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        // Borra tokens viejos si quieres (opcional)
        // $user->tokens()->delete();

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => $user,
        ]);
    }

    public function logout(Request $request)
    {
       $user = request()->user(); //or Auth::user()

        // Revoke current user token
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        // Crear usuario con datos validados
        $user = User::create([
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'is_admin' => $request->boolean('is_admin', false),
        ]);

        // Crear token para el usuario (Sanctum)
        $token = $user->createToken('auth_token')->plainTextToken;

        // Retornar UserResource + token
        return response()->json([
            'data'  => new UserResource($user),
            'token' => $token,
        ], 201);
    }

}
