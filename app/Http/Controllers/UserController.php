<?php

 

namespace App\Http\Controllers;

 

use App\Http\Requests\UserRequest;

use App\Http\Requests\UserUpdateRequest;

use App\Models\User;

use Illuminate\Http\RedirectResponse;

use Illuminate\View\View;

 

class UserController extends Controller

{

    public function index(): View

    {

        $users = User::paginate(5);

 

        return view('users.list', compact('users'));

    }

 

    public function create(): View

    {

        return view('users.create');

    }

 

    public function store(UserRequest $request): RedirectResponse

    {

        User::create($request->all());

 

        return redirect()->route('users.index')

            ->with('success', 'User created successfully.');

    }

 

    public function show(User $user)

    {

        // return view('users.show', compact('user'));

    }

 

    public function edit(User $user): View

    {

        return view('users.edit', compact('user'));

    }

 

    public function update(UserUpdateRequest $request, User $user): RedirectResponse

    {

 

        $user->update($request->all());

 

        return redirect()->route('users.index')

            ->with('success', 'User updated successfully');

    }

 

    public function destroy(User $user): RedirectResponse

    {

        $user->delete();

 

        return redirect()->route('users.index')

            ->with('danger', 'User deleted successfully');

    }

}