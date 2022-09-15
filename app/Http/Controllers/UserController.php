<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="Get user list",
     *     operationId="listUser",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Current page",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of the data per page",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="order_by",
     *         in="query",
     *         description="Field to be ordered",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="sort",
     *         in="query",
     *         description="Asc or Desc",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Filter the data",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/UserList")
     *     )
     * )
     */
    public function index(Request $request)
    {
        $users = User::where('email', '<>', 'admin@admin.com')
            ->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . str_replace(' ', '%', $request->input(key: 'search')) . '%')
                    ->orWhere('email', 'like', '%' . str_replace(' ', '%', $request->input(key: 'search')) . '%');
            })
            ->orderBy($request->input(key: 'orderBy'), $request->input(key: 'sort'))
            ->paginate($request->input(key: 'per_page'));
        return response()->json($users);
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="Create a user",
     *     operationId="saveUser",
     *     @OA\RequestBody(
     *         description="Create user object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreUserRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     */
    public function store(StoreUserRequest $request)
    {
        $input = $request->validated();
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
        ]);
        return response()->json($user);
    }

    /**
     * @OA\Get(
     *     path="/api/users/{userId}",
     *     tags={"Users"},
     *     summary="Get a user",
     *     operationId="getUser",
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         description="User id to be showned",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     */
    public function show($id)
    {
        $user = User::where([['id', $id], ['email', '<>', 'admin@admin.com']])->first();
        if ($user) {
            return response()->json($user);
        }
        return response()->json(['message' => 'User not found'], 404);
    }

    /**
     * @OA\Put(
     *     path="/api/users/{userId}",
     *     tags={"Users"},
     *     summary="Update a user",
     *     operationId="updateUser",
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         description="User id to be updated",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Update user object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $input = $request->validated();

        $user = User::where('email', '<>', 'admin@admin.com')->find($id);
        if ($user->exists()) {
            if (array_key_exists('name', $input)) {
                $user->name = $input['name'];
            }

            if (array_key_exists('email', $input)) {
                $user->email = $input['email'];
            }

            if (array_key_exists('password', $input)) {
                $user->password = $input['password'];
            }

            $user->save();
            return response()->json($user);
        }
        return response()->json(['message' => 'User not found'], 404);
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{userId}",
     *     tags={"Users"},
     *     summary="Delete a user",
     *     operationId="deleteUser",
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         description="User id to be deleted",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted successfully",
     *         @OA\JsonContent(ref="#/components/schemas/ApiResponse")
     *     )
     * )
     */
    public function destroy($id)
    {

        $user = User::where([['id', $id], ['email', '<>', 'admin@admin.com']]);
        if (!$user->exists()) {
            return response()->json(['User not found'], 404);
        }
        $result = $user->delete();
        if ($result) {
            return response()->json(['message' => 'User deleted successfully']);
        }
    }

    /**
     * @OA\Patch(
     *     path="/api/users/delete",
     *     tags={"Users"},
     *     summary="Delete multiples users",
     *     operationId="deleteAllUsers",
     *     @OA\Response(
     *         response=200,
     *         description="Users deleted successfully",
     *         @OA\JsonContent(ref="#/components/schemas/ApiResponse")
     *     )
     * )
     */
    public function destroyAll(Request $request)
    {
        $users = $request->all();
        DB::transaction(function () use ($users) {
            foreach ($users as $user) {
                User::where([['id', $user['id']], ['email', '<>', 'admin@admin.com']])->delete();
            }
        });
        return response()->json(['message' => 'Users deleted successfully']);
    }
}
