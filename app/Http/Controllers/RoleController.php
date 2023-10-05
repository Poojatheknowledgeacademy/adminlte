<?php

namespace App\Http\Controllers;
use Yajra\DataTables\Facades\Datatables;
use App\Models\Slug;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
            if ($request->ajax()) {
             $query = Role::with('creator');
            return Datatables::eloquent($query)->make(true);
        }
        // $roles = Role::all();
        // return view('roles.index', compact('roles'));
        return view('roles.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
{
    $id = auth()->user()->id;
    $is_active = $request->is_active == "on" ? 1 : 0;

    // Create a new role
        $role = Role::create([
        'name' => $request->name,
        'description' => $request->description,
        'is_active' => $is_active,
        "created_by" => $id,
    ]);

    return redirect()->route('roles.index')->with('success', 'Role created successfully');
}
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    
    {
        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        $is_active = $request->is_active == "on" ? 1 : 0;

        // Update the role attributes
      
        $role->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $is_active,
        ]);
    
        return redirect()->route('roles.index')->with('success', 'Role updated successfully');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        session()->flash('danger', 'Role Deleted successfully.');
        return redirect()->route('roles.index');
    }
}
