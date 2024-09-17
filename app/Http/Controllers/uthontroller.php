<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class uthController extends Controller
{
    // تسجيل المستخدم
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // افتراضيا نعطي الدور بناءً على طلب العميل (يمكن تخصيص هذا لاحقًا)
        $user->assignRole('developer');

        return response()->json(['message' => 'User successfully registered'], 201);
    }

    // تسجيل الدخول وإصدار التوكن
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    // تسجيل الخروج
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    // استرجاع المستخدم المسجل
    public function userProfile()
    {
        return response()->json(auth()->user());
    }

    // دالة مساعدة لإرجاع التوكن مع البيانات
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}