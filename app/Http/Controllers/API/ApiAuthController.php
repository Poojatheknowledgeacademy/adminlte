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
        return response()->json([
            'success' => true,
            'message' => 'Authenticated User Details.',
            'data' => [
                'user' => Auth::guard('api')->user(),
            ],
        ], 200);
    }
    public function login(UserLoginRequest $request)
    {

        $user = User::where('email', '=', $request->email)->first();
        if ($user) {

            if (Hash::check($request->password, $user->password)) {

                Auth::login($user);
                Auth::logoutOtherDevices($request->password);

                $fields = [
                    'user_id' => $user->id
                ];

                $data = [
                    'iss'   => 'adminlte',
                    'iat'   => time(),
                    'nbf'   => time(),
                    'exp'   => time() + 60 * 120,
                    'sub'   => 'Login',
                    'jti'   => md5('TKA' . time()),
                ];

                $data = array_merge($data, $fields);
                $key  =  config('jwt.key');
                $access_token = JWT::encode($data, $key, 'HS256');
                return response()->json([
                    'success' => true,
                    'message' => 'User Logged In Succesfully!',
                    'data' => [
                        'accessToken' => $access_token,
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
