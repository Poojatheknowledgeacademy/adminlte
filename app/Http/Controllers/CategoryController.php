<?php

namespace App\Http\Controllers;

use App\Models\Slug;
use App\Models\User;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CategoryRequest;
use App\Notifications\NewCourseCreated;
use Yajra\DataTables\Facades\Datatables;
use App\Notifications\NewcategoryCreated;
use App\Http\Requests\CategoryUpdateRequest;
use App\Mail\CategoryCreatedMail;

class CategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:category-list|category-insert|category-update|category-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:category-insert', ['only' => ['insert', 'store']]);
        $this->middleware('permission:category-update', ['only' => ['update', 'update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Category::with([
                'creator',
                'countries' => function ($query) {
                    $query->select('countries.*', 'country_category.deleted_at as pivot_deleted_at', 'country_category.is_popular as pivot_is_popular')
                        ->where('country_id', session('country')->id);
                },
            ]);
            return Datatables::eloquent($query)->make(true);
        }
        return view('category.list');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        if ($request->file('icon')) {
            $icon = $request->file('icon');
            $icon_name = time() . '_' . $icon->getClientOriginalName();

            // File upload location
            $icon_location = 'Images/icon/';

            // Upload file
            $icon->move($icon_location, $icon_name);
        }

        if ($request->file('logo')) {
            $logo = $request->file('logo');
            $logo_name = time() . '_' . $logo->getClientOriginalName();

            // File upload location
            $logo_location = 'Images/logo/';

            // Upload file
            $logo->move($logo_location, $logo_name);
        }

        $is_active = $request->is_active == "on" ? 1 : 0;
        $is_popular = $request->is_popular == "on" ? 1 : 0;
        $is_technical = $request->is_technical == "on" ? 1 : 0;

        $category = Category::create([
            'name' => $request->name,
            'icon' => $icon_location . $icon_name,
            'logo' => $logo_location . $logo_name,
            'is_active' => $is_active,
            'is_popular' => $is_popular,
            'is_technical' => $is_technical,
            'created_by' => Auth::user()->id
        ]);

        $category->slugs()->create([
            'slug' => $request->slug,
        ]);
        $category->countries()->attach($request->input('country', []));


        $message = (new CategoryCreatedMail($category))->onQueue('emails');
        Mail::to('arshdeep.singh@theknowledgeacademy.com')->later(now()->addSeconds(1), $message);

        session()->flash('success', 'Category Created successfully.');
        return redirect()->route('category.index');
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
    public function edit(Category $category): View
    {
        $slug = $category->slugs()->first();
        return view('category.edit', compact('category', 'slug'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, Category $category): RedirectResponse
    {
        if ($request->hasFile('icon')) {

            $icon_location = 'Images/icon/';
            if (!empty($category->icon)) {
                unlink(public_path($category->icon));
            }

            $icon = $request->file('icon');
            $icon_name = time() . '_' . $icon->getClientOriginalName();
            $icon_location = 'Images/icon/';
            $icon->move($icon_location, $icon_name);
            $category->icon = $icon_location . $icon_name;
        }

        if ($request['removeicontxt'] != null) {
            $category->icon = null;
        }

        if ($request->hasFile('logo')) {

            $logo_location = 'Images/logo/';
            if (!empty($category->logo)) {
                unlink(public_path($category->logo));
            }
            $logo = $request->file('logo');
            $logo_name = time() . '_' . $logo->getClientOriginalName();
            $logo_location = 'Images/logo/';
            $logo->move($logo_location, $logo_name);
            $category->logo = $logo_location . $logo_name;
        }

        if ($request['removelogotxt'] != null) {
            $category->logo = null;
        }

        $is_active = $request->is_active == "on" ? 1 : 0;
        $is_popular = $request->is_popular == "on" ? 1 : 0;
        $is_technical = $request->is_technical == "on" ? 1 : 0;

        $category->update([
            'name' => $request->name,
            'icon' => $category->icon,
            'logo' => $category->logo,
            'is_active' => $is_active,
            'is_popular' => $is_popular,
            'is_technical' => $is_technical
        ]);

        $category->slugs()->update(['slug' => $request->slug]);

        session()->flash('success', 'Category updated successfully.');
        return redirect()->route('category.index');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();
        session()->flash('danger', 'Category Deleted successfully.');
        return redirect()->route('category.index');
    }
    public function categoryStatus(Request $request)
    {
        $category = Category::find($request->id);
        $category->is_active = $request->is_active;
        $category->save();
        if ($request->is_active == 1) {
            return response()->json(['success' => 'Category Activated']);
        } else {
            return response()->json(['success' => 'Category Deactivated']);
        }
    }
    public function getActiveCategories()
    {
        if (request()->ajax()) {
            $query = Category::where('is_active', 1)
                ->with([
                    'creator',
                    'countries' => function ($query) {
                        $query->select('countries.*', 'country_category.deleted_at as pivot_deleted_at', 'country_category.is_popular as pivot_is_popular')
                            ->where('country_id', session('country')->id);
                    },
                ]);
            return Datatables::eloquent($query)->make(true);
        }
    }
    public function trashedCategory(Request $request)
    {
        if ($request->ajax()) {
            $trashedCategories = Category::onlyTrashed();
            return Datatables::eloquent($trashedCategories)->make(true);
        }
        return view('trash.category_list');
    }
    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();
        session()->flash('success', 'Category Restored successfully.');
        return redirect()->route('category.index');
    }
    public function delete($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->forceDelete();
        session()->flash('danger', 'Category Deleted successfully.');
        return view('trash.category_list');
    }
    public function storeCategoryCountry(Request $request)
    {
        // print_r($request->all());
        $category = Category::find($request->id);

        if ($request->checked == 'true') {
            $category->countries()->sync([session('country')->id => ['deleted_at' => null]]);
        } else {
            $category->countries()->updateExistingPivot(session('country')->id, [
                'deleted_at' => now(),
            ]);
            // $category->countries()->where('country_id', $request->country_id)->delete();
        }
    }
    public function setPopular(Request $request)
    {
        $category = Category::find($request->id);
        $category->countries()->updateExistingPivot(session('country')->id, [
            'is_popular' =>  $request->is_popular,
        ]);

        if ($request->is_popular == 1) {
            return response()->json(['success' => 'Category Popular Activated']);
        } else {
            return response()->json(['success' => 'Category Popular Deactivated']);
        }
    }
}
