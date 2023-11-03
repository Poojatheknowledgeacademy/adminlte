<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::guard('api')->check()) {
            return response()->json([
                'error' => 'Not Authenticated',
            ], 404);
        }

        $users = User::all();
        return response()->json([
            'success' => true,
            'data' => $users->toArray()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //echo "dddd";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request,  User $user)
    {
        $user->update($request->all());
        DB::table('model_has_roles')->where('model_id', $user->id)->delete();
        $user->assignRole($request->input('roles'));

       // return $this->sendResponse(new UserResource($user), 'User updated successfully.');
        return (new UserResource($user))->response();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //$user->delete();
    }
}
