<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\Datatables;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\EditcourseRequest;
use App\Models\Course;
use App\Models\Topic;


class CourseController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:course-list|course-insert|course-update|course-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:course-insert', ['only' => ['insert', 'store']]);
        $this->middleware('permission:course-update', ['only' => ['update', 'update']]);
        $this->middleware('permission:course-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Course::with('creator', 'topic');
            return Datatables::eloquent($query)->make(true);
        }
        return view('course.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $topic = Topic::where('is_active', 1)->get();
        return view('course.create', compact('topic'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {

        $courseimage = $request->file('logo');
        $courseimagename = time() . '_' . $courseimage->getClientOriginalName();
        $courselocation = 'Images/courselogo/';
        // Upload file
        $courseimage->move($courselocation, $courseimagename);
        $filepath = $courselocation . $courseimagename;

        $id = auth()->user()->id;
        if ($request->is_active == 'on') {
            $active = '1';
        } else {
            $active = '0';
        }
        $data = $request->validated();


        $course = Course::create([
            "name" => $request->name,
            "topic_id" => $request->topic_id,
            "logo" => $filepath,
            "is_active" => $active,
            "created_by" => $id,
        ]);
        $course->slugs()->create([
            'slug' => $request->slug,
        ]);

        return redirect()->route('course.index')->with('success', 'Course Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $topic = Topic::all();
        $slug = $course->slugs()->first();
        return view('course.edit', compact('course', 'topic', 'slug'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(EditcourseRequest $request, Course $course)
    {
        if ($request->is_active == 'on') {
            $active = '1';
        } else {
            $active = '0';
        }

        $course->topic_id = $request->topic_id;
        $course->is_active = $active;
        $course->name = $request->name;

        // Handle logo update
        if ($request->hasFile('logo')) {
            $courselogolocation = 'Images/courselogo/';

            if (!empty($course->logo)) {
                unlink(public_path($course->logo));
            }

            $feature_image1 = $request->file('logo');
            $courselogoname = time() . '_' . $feature_image1->getClientOriginalName();
            $feature_image1->move($courselogolocation, $courselogoname);
            $course->logo =  $courselogolocation . $courselogoname;
        }

        // Handle logo removal
        if ($request['removelogotxt'] != null) {
            $course->logo = null;
        }
        $course->slugs()->update(['slug' => $request->slug]);
        $course->save();

        return redirect()->route('course.index')->with('success', 'Course Updated Successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('course.index')
            ->with('danger', 'Course deleted successfully');
    }
    public function courseStatus(Request $request){
        $course = Course::find($request->id);
        $course->is_active = $request->is_active;
        $course->save();
        if($request->is_active==1){
           return response()->json(['success' => 'course Activated']);
        }else{
            return response()->json(['success' => 'course Deactivated']);
        }
    }
}
