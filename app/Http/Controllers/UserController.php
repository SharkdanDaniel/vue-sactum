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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::where('email', '<>', 'admin@admin.com')
            ->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . str_replace(' ', '%', $request->input(key:'search')) . '%')
                    ->orWhere('email', 'like', '%' . str_replace(' ', '%', $request->input(key:'search')) . '%');
            })
            ->orderBy($request->input(key:'orderBy'), $request->input(key:'sort'))
            ->paginate($request->input(key:'per_page'));
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
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
     * Remove multiple resources from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
