<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\Datatables;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Models\Module;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:role-list|role-create|role-update|role-delete', ['only' => ['index', 'store']]);
        // $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:role-update', ['only' => ['update', 'update']]);
        // $this->middleware('permission:role-delete', ['only' => ['destroy']]);
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
        return view('roles.list');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modulesWithPermissions = Module::where('is_active', 1)->with('permissions')->get();
        return view('roles.create', compact('modulesWithPermissions'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $is_active = $request->is_active == "on" ? 1 : 0;
        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $is_active
        ]);
        if ($request->permissions) {
            $selectedPermissions = $request->input('permissions', []);
            $role->syncPermissions($selectedPermissions);
        }
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

        $modulesWithPermissions = Module::where('is_active', 1)->with('permissions')->get();
        return view('roles.edit', compact('role','modulesWithPermissions'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        $is_active = $request->is_active == "on" ? 1 : 0;

        $role->update(['name' => $request->name, 'description' => $request->description, 'is_active' => $is_active]);

        $selectedPermissions = $request->input('permissions', []);
        $role->syncPermissions($selectedPermissions);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully');
        $is_active = $request->is_active == "on" ? 1 : 0;
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        $role->permissions()->detach();

        session()->flash('danger', 'Role Deleted successfully.');
        return redirect()->route('roles.index');
    }
    public function roleStatus(Request $request){
        $role = Role::find($request->id);
        $role->is_active = $request->is_active;
        $role->save();
        if($request->is_active==1){
            session()->flash('success', 'Role Activated');
        }else{
            session()->flash('danger', 'Role Deactivated');
        }
        return response()->json([
            'redirect' => route('roles.index'),
        ]);


    }
}
