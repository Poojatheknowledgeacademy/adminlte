<?php

namespace App\Http\Controllers;

use App\Models\Failed_Jobs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\Datatables;

class Failed_JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
          $query = Failed_Jobs::query();
            return Datatables::eloquent($query)->make(true);
        }
        return view('failed_jobs.list');
    }

    /**
     * Display the specified resource.
     */
    public function show(Failed_Jobs $failed_Jobs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $failedJob = Failed_Jobs::find($id);

        if (!$failedJob) {
            return response()->json(['error' => 'Failed Job not found.'], 404);
        }

        // Permanent delete
        $failedJob->forceDelete();

        return response()->json(['message' => 'Failed Job deleted successfully.']);
    }
}
