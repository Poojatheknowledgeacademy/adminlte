<?php

namespace App\Http\Controllers;
use Yajra\DataTables\Facades\Datatables;
use App\Models\Coursedetail;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Country;
use App\Http\Requests\EditCoursedetailRequest;
use App\Http\Requests\CoursedetailRequest;
use Illuminate\Support\Facades\Auth;

class CoursedetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id)
    {
        if ($request->ajax()) {
            $query = Coursedetail::with('country','course');
            $query->where('course_id', $id);
            return Datatables::eloquent($query)->make(true);
        }
        return view('course.detail.list', compact('id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $courses = Course::where('is_active', 1)->get();
        $countries = Country::get();
        return view('course.detail.create', compact('id', 'courses','countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($id, CoursedetailRequest $request)
    {
        CourseDetail::create([
            'course_id' => $request->course_id,
            'country_id' => $request->country_id,
            'heading' => $request->heading,
            'summary' => $request->summary,
            'detail' => $request->detail,
            'overview' => $request->overview,
            'whats_included' => $request->whats_included,
            'pre_requisite' => $request->pre_requisite,
            'who_should_attend' => $request->who_should_attend,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'created_by' => Auth::user()->id
        ]);
        return redirect()->route('course.coursedetails.index',$request->course_id)->with('success', 'Course Detail created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Coursedetail $coursedetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id,Coursedetail $coursedetail)
    {

        $courses = Course::where('is_active', 1)->get();
        $countries = Country::get();
        return view('course.detail.edit', compact('id','coursedetail', 'courses','countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id,EditCoursedetailRequest $request, Coursedetail $coursedetail)
    {
        $coursedetail->update([
            'course_id' => $request->course_id,
            'country_id' => $request->country_id,
            'heading' => $request->heading,
            'summary' => $request->summary,
            'detail' => $request->detail,
            'overview' => $request->overview,
            'whats_included' => $request->whats_included,
            'pre_requisite' => $request->pre_requisite,
            'who_should_attend' => $request->who_should_attend,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
        ]);
        return redirect()->route('course.coursedetails.index',$coursedetail->course_id)->with('success', 'Course Detail Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id,Coursedetail $coursedetail)
    {
         $coursedetail->delete();
         return redirect()->route('course.coursedetails.index',$coursedetail->course_id)
         ->with('danger', 'Course Detail deleted successfully');
    }
}
