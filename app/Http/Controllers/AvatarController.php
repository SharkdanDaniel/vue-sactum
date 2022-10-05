<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAvatarRequest;
use App\Models\Avatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * @OA\Get(
     *     path="/api/avatars/{avatarId}",
     *     tags={"Avatars"},
     *     summary="Get an avatar",
     *     operationId="getAvatar",
     *     @OA\Parameter(
     *         name="avatarId",
     *         in="path",
     *         description="Avatar id to be shown",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Avatar")
     *     )
     * )
     */
    public function show()
    {
        $user = auth()->user();
        $avatar = Avatar::where('user_id', $user['id'])->get();
        $avatar['data'] = getImageBase64($avatar['media_type'], $avatar['path']);
        return response()->json($avatar);
    }

    /**
     * @OA\Post(
     *     path="/api/avatars",
     *     tags={"Avatars"},
     *     summary="Create an avatar",
     *     operationId="createAvatar",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="image to upload",
     *                     property="image",
     *                     type="string",
     *                     format="binary",
     *                 ),
     *             ),
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Product created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Avatar")
     *     )
     * )
     */

    public function store(StoreAvatarRequest $request)
    {
        $request->validated();
        $user = auth()->user();
        $avatar = Avatar::create([
            'file_name' => $request->file('image')->getClientOriginalName(),
            'media_type' => $request->file('image')->getClientMimeType(),
            'path' => $request->file('image')->store('public/images'),
            'user_id' => $user['id'],
        ]);
        $data = base64_encode(Storage::get($avatar->path));
        if(!is_null($data)) $avatar->src = "data:$avatar->media_type;base64,$data";
        return response()->json($avatar);
    }

    /**
     * @OA\Put(
     *     path="/api/avatars/{avatarId}",
     *     tags={"Avatars"},
     *     summary="Update an avatar",
     *     operationId="updateAvatar",
     *     @OA\Parameter(
     *         name="avatarId",
     *         in="path",
     *         description="Avatar id to be updated",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="image to upload",
     *                     property="image",
     *                     type="string",
     *                     format="binary",
     *                 ),
     *             ),
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Avatar updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Avatar")
     *     )
     * )
     */
    public function update(Request $request, Avatar $avatar)
    {
        return response()->json($request->all());
        // $request->validated();
        // Storage::delete($avatar->path);
        // $avatar->file_name = $request->file('image')->getClientOriginalName();
        // $avatar->media_type = $request->file('image')->getClientMimeType();
        // $avatar->path = $request->file('image')->store('public/images');
        // $avatar->save();
        // $data = base64_encode(Storage::get($avatar->path));
        // if(!is_null($data)) $avatar->src = "data:$avatar->media_type;base64,$data";
        // return response()->json($avatar);
    }

    /**
     * @OA\Delete(
     *     path="/api/avatars/{avatarId}",
     *     tags={"Avatars"},
     *     summary="Delete an avatar",
     *     operationId="deleteAvatar",
     *     @OA\Parameter(
     *         name="avatarId",
     *         in="path",
     *         description="Avatar id to be deleted",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Avatar deleted successfully",
     *         @OA\JsonContent(ref="#/components/schemas/ApiResponse")
     *     )
     * )
     */
    public function destroy(Avatar $avatar)
    {
        $avatar->delete();
        Storage::delete($avatar->path);
        return response()->json(['message' => 'Avatar deleted successfully']);
    }
}
