<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\XmlConfiguration\Group;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    //users
    Route::patch('users/delete', [UserController::class, 'destroyAll']);
    Route::get('auth/user', [AuthController::class, 'authUser']);
    //products
    Route::patch('products/delete', [ProductController::class, 'destroyAll']);
    Route::apiResources([
        // users
        'users' => UserController::class,
        // products
        'products' => ProductController::class,
        // avatars
        'avatars' => AvatarController::class,
    ]);    
});

Route::any('{any}', function () {
    return response()->json(['message' => 'Route not found'], 404);
});