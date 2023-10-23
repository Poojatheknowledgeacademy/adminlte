<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreBlogdetailsRequest;
use App\Http\Requests\UpdateBlogdetailRequest;
use App\Models\BlogDetail;
use App\Models\Blog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;

class BlogDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id)
    {
        if ($request->ajax()) {
            $query = BlogDetail::with('creator', 'blog');
            return Datatables::eloquent($query)->make(true);
        }
        return view('blog.details.list', compact('id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {

        return view('blog.details.create', compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($id, StoreBlogdetailsRequest $request)
    {
        $blog_id =  Blog::findOrFail($id);
        $is_active = $request->is_active == "on" ? 1 : 0;
        $blogdetail = new BlogDetail([
            'meta_title' => $request->tittle,
            'meta_keywords' => $request->keywords,
            'meta_description' => $request->description,
            'summary' => $request->summary,
            'is_active' => $is_active
        ]);
        $blog_id->blogid()->save($blogdetail);
        $blogdetail->save();
        return redirect()->route('blogs.blogDetail.index', $id)
            ->with('success', 'Blogdetails created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogDetail $blogDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, BlogDetail $blogDetail)
    {

        return view('blog.details.edit', compact('id', 'blogDetail'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateBlogdetailRequest $request, BlogDetail $blogDetail)
    {

        $is_active = $request->is_active == "on" ? 1 : 0;
        $blogDetail->update([
            'meta_title' => $request->title,
            'meta_keywords' => $request->keywords,
            'meta_description' => $request->description,
            'summary' => $request->summary,
            'is_active' => $is_active
        ]);
        return redirect()->route('blogs.blogDetail.index', $id)
            ->with('success', 'Blogdetails created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, BlogDetail $blogDetail)
    {
        $blogDetail->delete();
        return redirect()->route('blogs.blogDetail.index', $id)
            ->with('success', 'Blogdetails deleted successfully.');
    }
    public function updateStatus(Request $request)
    {
        $blogdetails = BlogDetail::find($request->id);
        $blogdetails->is_active = $request->is_active;
        $blogdetails->save();
        if ($request->is_active == 1) {
            return response()->json(['success' => 'Blogdetails Activated']);
        } else {
            return response()->json(['success' => 'Blogdetails  Deactivated']);
        }
    }
}
