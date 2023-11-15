<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\Datatables;


class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Jobs::latest()->get(); // Adjust this based on your actual data retrieval logic

            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-danger btn-sm delete-job" data-job-id="' . $row->id . '">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('jobs.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      //
    }

    /**
     * Display the specified resource.
     */
    public function show(Jobs $jobs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jobs $jobs)
    {
       //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $job = Jobs::find($id);

        if (!$job) {
            return response()->json(['error' => 'Job not found.'], 404);
        }

        // Permanent delete
        $job->forceDelete();

        return response()->json(['message' => 'Job deleted successfully.']);
    }
}

