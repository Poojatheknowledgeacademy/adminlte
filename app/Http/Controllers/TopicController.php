<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\Datatables;
use Illuminate\Http\Request;
use App\Http\Requests\TopicRequest;
use App\Models\Topic;
use App\Models\Category;
use App\Models\Slug;
use App\Http\Requests\TopicUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $topics = Topic::paginate(5);
        // return view('topic.list', compact('topics'));

        if ($request->ajax()) {
            $query = Topic::with('creator', 'category');
            return Datatables::eloquent($query)->make(true);
        }
        return view('topic.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', 1)->get();

        return view('topic.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TopicRequest $request): RedirectResponse
    {

        if ($request->file('logo')) {

            $logo = $request->file('logo');
            $logo_name = time() . '_' . $logo->getClientOriginalName();

            // File upload location
            $logo_location = 'Images/logo/';

            // Upload file
            $logo->move($logo_location, $logo_name);
        }



        $category_id = $request->category_id;

        $is_active = $request->is_active == "on" ? 1 : 0;

        $topic = Topic::create([
            'name' => $request->name,
            'category_id' => $category_id,
            'logo' => $logo_location . $logo_name,
            'is_active' => $is_active,

        ]);

        $topic->slugs()->create([
            'slug' => $request->slug,
        ]);

        session()->flash('success', 'Topic Created successfully.');
        return redirect()->route('topic.index');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Topic $topic): View
    {
        $categories = Category::where('is_active', 1)->get();
        $slug = $topic->slugs()->first();
        return view('topic.edit', compact('topic', 'categories', 'slug'));
    }
    public function update(TopicUpdateRequest $request, Topic $topic): RedirectResponse
    {
        if ($request->hasFile('logo')) {
            $logo_location = 'Images/logo/';

            // Remove old file
            if (!empty($topic->logo)) {
                unlink(public_path($topic->logo));
            }

            // Upload new file
            $logo = $request->file('logo');
            $logo_name = time() . '_' . $logo->getClientOriginalName();
            $logo->move($logo_location, $logo_name);

            $topic->logo = $logo_location . $logo_name;
        }

        if ($request->input('removelogotxt')) {
            $topic->logo = null;
        }

        $is_active = $request->has('is_active') ? 1 : 0;

        $topic->update([
            'name' => $request->input('name'),
            'category_id' => $request->input('category_id'),
            'logo' => $topic->logo,
            'is_active' => $is_active,
        ]);

        $topic->slugs()->update(['slug' => $request->slug]);

        session()->flash('success', 'Topic updated successfully.');

        return redirect()->route('topic.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic $topic): RedirectResponse
    {
        $topic->delete();
        session()->flash('danger', 'Topic Deleted successfully.');
        return redirect()->route('topic.index');
    }
}
