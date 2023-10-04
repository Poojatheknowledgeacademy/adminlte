<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Http\Requests\TagRequest;
use App\Http\Requests\TagUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $tags = Tag::paginate(5);
        return view('tag.list', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::where('is_active', 1)->get();
        return view('tag.create', ['tags' => $tags]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request): RedirectResponse
    {
        $is_active = $request->is_active == "on" ? 1 : 0;
        Tag::create([
            'name' => $request->name,
            'is_active' => $is_active
        ]);
        session()->flash('success', 'Tag Created successfully.');
        return redirect()->route('tag.index');
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
    public function edit(Tag $tag): View
    {
        return view('tag.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagUpdateRequest $request, Tag $tag): RedirectResponse
    {
        $is_active = $request->is_active == "on" ? 1 : 0;
        $tag->update([
            'name' => $request->name,
            'is_active' => $is_active
        ]);
        session()->flash('success', 'Tag updated successfully.');
        return redirect()->route('tag.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag): RedirectResponse
    {
        $tag->delete();
        session()->flash('danger', 'Tag Deleted successfully.');
        return redirect()->route('tag.index');
    }
}
