<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\PermissionRequest;
use Yajra\DataTables\Facades\Datatables;
use App\Http\Requests\PermissionUpdateRequest;
use App\Models\Module;


class PermissionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:permission-list|permission-insert|permission-update|permission-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:permission-insert', ['only' => ['insert', 'store']]);
        $this->middleware('permission:permission-update', ['only' => ['update', 'update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Permission::with('module');
            return Datatables::eloquent($query)->make(true);
        }
        return view('permission.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $modules = Module::where('is_active', 1)->get();
        return view('permission.create', compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request): RedirectResponse
    {
        $is_active = $request->is_active == "on" ? 1 : 0;
        $module = Module::find($request->module_id);
        $name = strtolower($module->name) . "-" . $request->access;

        $haspermission = Permission::query()
            ->where('name', $name)
            ->where('module_id', $request->input('module_id'))
            ->exists();

        if ($haspermission) {
            return back()->withErrors([
                'access' => 'Access already exits.'
            ]);
        }

        Permission::create([
            'module_id' => $request->module_id,
            'name' => $name,
            'guard_name' => 'web',
            'description' => $request->description,
            'is_active' => $is_active,
        ]);

        return redirect()->route('permission.index')
            ->with('success', 'Permission created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('permission.edit', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission): View
    {
        $modules = Module::where('is_active', 1)->get();
        return view('permission.edit', compact('permission', 'modules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionUpdateRequest $request, Permission $permission)
    {

        $is_active = $request->has('is_active') ? 1 : 0;
        $module = Module::find($request->module_id);
        $name = strtolower($module->name) . "-" . $request->access;

        $haspermission = Permission::query()
            ->where('name', $name)
            ->where('module_id', $request->input('module_id'))
            ->where('id', '!=', $permission->id)
            ->exists();

        if ($haspermission) {
            return back()->withErrors([
                'access' => 'Access already exits.'
            ]);
        }

        $permission->update([
            'module_id' => $request->module_id,
            'name' => strtolower($module->name) . "-" . $request->access,
            'guard_name' => 'web',
            'description' => $request->description,
            'is_active' => $is_active,

        ]);
        return redirect()->route('permission.index')
            ->with('success', 'Permission updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission): RedirectResponse
    {
        $permission->delete();
        session()->flash('danger', 'Permission Deleted successfully.');
        return redirect()->route('permission.index');
    }
    public function permissionStatus(Request $request)
    {
        $permission = Permission::find($request->id);
        $permission->is_active = $request->is_active;
        $permission->save();
        if ($request->is_active == 1) {
            return response()->json(['success' => 'permission Activated']);
        } else {
            return response()->json(['success' => 'permission Deactivated']);
        }
    }

    public function trashedPermission(Request $request)
    {
        if ($request->ajax()) {
            $trashedPermissions = Permission::onlyTrashed();
            return Datatables::eloquent($trashedPermissions)->make(true);
        }
        return view('trash.permission_list');
    }

    public function restore($id)
    {
        $permission = Permission::withTrashed()->findOrFail($id);
        $permission->restore();
        session()->flash('success', 'Permission Restored successfully.');

        // Redirect to a route that displays the list of trashed permissions
        return redirect()->route('permission.index');
    }

    public function delete($id)
    {
        $permission = Permission::withTrashed()->findOrFail($id);
        $permission->forceDelete();
        session()->flash('danger', 'Permission Deleted successfully.');

        // Redirect to a route that displays the list of trashed permissions
        return redirect()->route('trashedPermission');
    }
}
