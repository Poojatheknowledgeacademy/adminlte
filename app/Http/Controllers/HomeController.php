<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\Datatables;
use App\Models\Course;
use App\Models\CountryCourse;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $query = CountryCourse::with('course_name','country_name');
            $query->where('country_id', session('country')->id);

            return Datatables::eloquent($query)->make(true);
        }
        $course_count = CountryCourse::where('country_id',session('country')->id)->count();
        // print_r(session('country'));
        // print_r(session('country')->id);
        // $request->session()->get('country');

        return view('home.index',compact('course_count'));
    }
}
