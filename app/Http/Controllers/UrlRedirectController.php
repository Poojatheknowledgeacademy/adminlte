<?php

namespace App\Http\Controllers;


use App\Models\UrlRedirect;
use Illuminate\Http\Request;
use App\Http\Requests\UrlRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UrlUpdateRequest;
use Yajra\DataTables\Facades\Datatables;

class UrlRedirectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = UrlRedirect::query();
            return Datatables::eloquent($query)->make(true);
        }
        return view('url_redirect.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('url_redirect.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UrlRequest $request)
    {
        UrlRedirect::create([
            'source_url' => $request->source_url,
            'redirect_url' => $request->redirect_url
        ]);

        return redirect()->route('url_redirect.index')->with('success', 'UrlRedirect created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(UrlRedirect $url)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UrlRedirect $url_redirect)
    {
        return view('url_redirect.edit', compact('url_redirect'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UrlUpdateRequest $request, UrlRedirect $url_redirect): RedirectResponse
    {
       // $url_redirect->update($request->all());
        $url_redirect->update([
            'source_url' => $request->source_url,
            'redirect_url' => $request->redirect_url
        ]);
        return redirect()->route('url_redirect.index')->with('success', 'UrlRedirect updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */


    public function destroy(UrlRedirect $url_redirect): RedirectResponse
    {
        $url_redirect->delete();

        return redirect()->route('url_redirect.index')
            ->with('danger', 'UrlRedirect deleted successfully.');
    }
}
