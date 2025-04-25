<?php

namespace App\Http\Controllers\UserService;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Cek apakah email ada
        $user = User::where('email', $credentials['email'])->first();
        if (!$user) {
            return response()->json(['error' => 'Email tidak ditemukan'], 404);
        }

        // Cek apakah password cocok
        if (!\Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'Password salah'], 401);
        }

        // Jika email dan password cocok, buat token
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Gagal login'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Tidak bisa membuat token'], 500);
        }

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'expires_in'   => JWTAuth::factory()->getTTL() * 60,
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'User registered',
            'token'   => $token,
            'user'    => $user,
        ], 201);
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function profile()
    {
        return response()->json(auth('api')->user());
    }
}
