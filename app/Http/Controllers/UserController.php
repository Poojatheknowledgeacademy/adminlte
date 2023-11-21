<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\UserCreatedMail;
use App\Http\Requests\UserRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserUpdateRequest;
use Yajra\DataTables\Facades\Datatables;
use App\Http\Requests\UserActivateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:user-list|user-insert|user-update|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:user-insert', ['only' => ['insert', 'store']]);
        $this->middleware('permission:user-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::with('creator');
            return Datatables::eloquent($query)->make(true);
        }
        return view('users.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(UserRequest $request): RedirectResponse
    {
        $token = Str::random(100);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'created_by' =>  Auth::user()->id,
            'remember_token' => $token
        ]);

        $user->assignRole($request->input('roles'));
        $message = (new UserCreatedMail($user))->onQueue('emails');
        Mail::to($user->email)->later(now()->addSeconds(1), $message);
        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */

    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        $roles = Role::all();

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {

        $user->update($request->all());
        DB::table('model_has_roles')->where('model_id', $user->id)->delete();
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('danger', 'User deleted successfully');
    }


    public function activateaccount($remember_token)
    {
        $user = User::where('remember_token', $remember_token)->first();

        if ($user) {
            return view('users.activateaccount')->with('user', $user)->with('token', $remember_token);
        }
    }

    public function postactivate(UserActivateRequest $request, $token)
    {
        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        if ($user) {
            $user = User::where('remember_token', $token)->where('email', $request['email'])->firstOrFail();
            $user->password = bcrypt($request['password']);
            $user->remember_token = Str::random(100);
            $user->is_active = 1;
            $user->save();
            Auth::loginUsingId($user->id);
            return redirect("dashboard")->withSuccess('Signed in successfully after resetting password');
        } else {
            return redirect()->route('activateaccount', $token)
                ->with('error', 'Email is not valid');
        }
    }
    public function trashedUser(Request $request)
    {
        if ($request->ajax()) {
            $trashedUsers = User::onlyTrashed();
            return Datatables::eloquent($trashedUsers)->make(true);
        }
        return view('trash.user_list');
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        session()->flash('success', 'User Restored successfully.');
        return redirect()->route('users.index');
    }


    public function delete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();
        session()->flash('danger', 'User Deleted successfully.');
        return redirect()->route('trashedUser');
    }
}
