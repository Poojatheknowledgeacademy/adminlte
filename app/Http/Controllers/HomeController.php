<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\Datatables;
use App\Models\Course;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Course::with('creator', 'topic');
            return Datatables::eloquent($query)->make(true);
        }
        $course_count = Course::count();
        return view('home.index',compact('course_count'));
    }
}
