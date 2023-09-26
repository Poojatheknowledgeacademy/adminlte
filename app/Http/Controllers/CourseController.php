<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\EditcourseRequest;
use App\Models\Course;
use App\Models\Topic;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $course = Course::paginate(2);
        return view('course.list',compact('course'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $topic = Topic::all();
        return view('course.create',compact('topic'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        //
        //print_r($request->all());
        //die();
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
        Course::create(array_merge($request->all(), ["created_by" => $id, "is_active" => $active, "logo" => $filepath, ]));
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
       // print_r($course);
        return view('course.edit', compact('course','topic'));
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
        $course->slug = $request->slug;

        if ($request->file('logo')) {
            $courselogolocation = 'Images/courselogo/';
            if (!empty($course->logo)) {
                unlink(public_path($course->logo));
            }
            $feature_image1 = $request->file('logo');
            $courselogoname = time() . '_' . $feature_image1->getClientOriginalName();
            $feature_image1->move( $courselogolocation, $courselogoname);
            // $course->update(["featured_img1" =>  $courselogolocation . $courselogoname]);
            $course->logo =  $courselogolocation . $courselogoname;
        }
        if ($request['removelogotxt'] != null) {
            $course->logo = null;
        }

        $course->save();

        return redirect()->route('course.index')->with('success', 'Course Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $post = Course::find($course->id);
        $post->delete();
        return redirect()->route('course.index')->with('success', 'Course Deleted Successfully');
    }
}
