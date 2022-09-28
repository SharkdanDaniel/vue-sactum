<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Avatar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Auth"},
     *     summary="Login",
     *     operationId="login",
     *     @OA\RequestBody(
     *         description="Login object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Logged in successfully",
     *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
     *     )
     * )
     */
    public function login(LoginRequest $request)
    {
        try {
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
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     tags={"Auth"},
     *     summary="Logout",
     *     operationId="logout",
     *     @OA\Response(
     *         response=200,
     *         description="Logged off successfully",
     *         @OA\JsonContent(ref="#/components/schemas/ApiResponse")
     *     )
     * )
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @OA\Get(
     *     path="/api/auth/user",
     *     tags={"Auth"},
     *     summary="Get auth user",
     *     operationId="authUser",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     */
    public function authUser()
    {
        $user = User::where('id', Auth::id())->with('avatar')->first();
        $avatar = $user['avatar'];
        if(!is_null($avatar)) $user['avatar']['data'] = getImageBase64($avatar['media_type'], $avatar['path']);
        return response()->json($user);
    }
}
