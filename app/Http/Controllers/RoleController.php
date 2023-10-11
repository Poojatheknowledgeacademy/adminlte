<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\Datatables;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\RoleUpdateRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Role::query();
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
        $permission = Permission::where('is_active', 1)->get();
        return view('roles.create', compact('permission'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $is_active = $request->is_active == "on" ? 1 : 0;
        // Create a new role
        $role = Role::create(['name' => $request->name, 'description' => $request->description, 'is_active' => $is_active]);
        $role->syncPermissions($request->input('permission'));

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
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $role->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        $is_active = $request->is_active == "on" ? 1 : 0;
        // Update the role attributes
        $role->update(['name' => $request->name, 'description' => $request->description, 'is_active' => $is_active]);
        $role->syncPermissions($request->input('permission'));

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
