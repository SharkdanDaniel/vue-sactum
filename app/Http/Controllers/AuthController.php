<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a sanctum token via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $input = $request->validated();
        $credentials = [
            'email' => $input['email'],
            'password' => $input['password'],
        ];
        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $user = User::where('email', $credentials['email'])->first();
        $token = $user->createToken($credentials['email']);
        return response()->json([
            'access_token' => $token->plainTextToken,
            'token_type' => 'bearer',
            // 'expires_in' => auth()->expiration(),
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authUser()
    {
        return response()->json(auth()->user());
    }
}
