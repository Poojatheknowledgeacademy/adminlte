<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;

class ApiAuthController extends Controller
{
    public function authenticatedUserDetails()
    {


        if (Auth::guard('api')->check()) {

            return response()->json([
                'success' => true,
                'message' => 'Authenticated User Details.',
                'data' => [
                    'user' => Auth::guard('api')->user(),
                ],
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized',
            'data' => null,
        ], 401);
    }
    public function login(UserLoginRequest $request)
    {
        if (User::where('email', '=', $request->email)->exists()) {
            $user = User::where('email', '=', $request->email)->first();

            if (Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => true,
                    'message' => 'User Logged In Succesfully!',
                    'data' => [
                        'accessToken' => JWT::encode(['user_id' => $user->id], config('jwt.key'), 'HS256'),
                    ],
                ], 200);
            }

            return response()->json([
                'success' => true,
                'message' => 'Wrong User Credential!',
                'data' => null,
            ], 400);
        }

        return response()->json([
            'success' => false,
            'message' => 'No User With That Email Address!',
            'data' => null,
        ], 404);
    }
}
