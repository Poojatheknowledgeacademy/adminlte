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
        $this->middleware('permission:permission-list|permission-create|permission-update|permission-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:permission-create', ['only' => ['create', 'store']]);
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
        Permission::create([
            'module_id' => $request->module_id,
            'name' => strtolower($module->name)."-".$request->access,$request->access,
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
        return view('permission.edit', compact('permission','modules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionUpdateRequest $request, Permission $permission)
    {
        $is_active = $request->has('is_active') ? 1 : 0;
        $module = Module::find($request->module_id);
        $permission->update([
            'module_id' => $request->module_id,
            'name' => strtolower($module->name)."-".$request->access,$request->access,
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
            session()->flash('success', 'permission Activated');
        } else {
            session()->flash('danger', 'permission Deactivated');
        }
        return response()->json([
            'redirect' => route('permission.index'),
        ]);
    }
}
