<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Requests\ModuleRequest;
use Yajra\DataTables\Facades\Datatables;
use App\Http\Requests\ModuleUpdateRequest;

class ModuleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:module-list|module-insert|module-update|module-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:module-insert', ['only' => ['insert', 'store']]);
        $this->middleware('permission:module-update', ['only' => ['update', 'update']]);
        $this->middleware('permission:module-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Module::query();
            return Datatables::eloquent($query)->make(true);
        }
        return view('module.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('module.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ModuleRequest $request)
    {
        $is_active = $request->is_active == "on" ? 1 : 0;
        Module::create([
            'name' => $request->name,
            'is_active' => $is_active
        ]);
        session()->flash('success', 'Module Created successfully.');
        return redirect()->route('module.index');
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
    public function edit(Module $module): View
    {

        return view('module.edit', compact('module'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ModuleUpdateRequest $request, Module $module)
    {
        $is_active = $request->is_active == "on" ? 1 : 0;
        $module->update([
            'name' => $request->name,
            'is_active' => $is_active
        ]);
        session()->flash('success', 'Module updated successfully.');
        return redirect()->route('module.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $module)
    {
        $module->delete();
        session()->flash('danger', 'Module Deleted successfully.');
        return redirect()->route('module.index');
    }

    public function updateStatus(Request $request)
    {
        $module = Module::find($request->id);
        $module->is_active = $request->is_active;
        $module->save();
        if ($request->is_active == 1) {
           return response()->json(['success' => 'Module Activated']);
        } else {
            return response()->json(['success' => 'Module Activated']);
        }
    }
}
