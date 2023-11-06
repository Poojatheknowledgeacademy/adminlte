<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $users = User::all();
        return response()->json([
            'success' => true,
            'data' => UserResource::collection($users)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $created_by = Auth::guard('api')->user()->id;
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'created_by' => $created_by
        ]);

        $user->assignRole($request->input('roles'));

        return response()->json([
            'success' => true,
            'message' => 'User Created Successfully',
            'data' => new UserResource($user)
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request,  User $user)
    {
        $user->update($request->all());
        DB::table('model_has_roles')->where('model_id', $user->id)->delete();
        $user->assignRole($request->input('roles'));

        return response()->json([
            'success' => true,
            'message' => 'User Updated Successfully',
            'data' => new UserResource($user)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'User Deleted Successfully'
        ], 400);
    }
}
