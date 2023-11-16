<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserLoginRequest;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function customLogin(UserLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            Auth::logoutOtherDevices($request->input('password'));
            return redirect()->route('home.index')->withSuccess('Signed in successfully');
        } else {
            return redirect("login")->with('error', 'Login details are not valid');
        }
    }
    public function registration()
    {
        return view('auth.registration');
    }

    public function customRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $check = $this->create($data);

        return redirect("dashboard")->withSuccess('have signed-in');
    }


    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function dashboard()
    {
        if (Auth::check()) {
            return view('auth.dashboard');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}
