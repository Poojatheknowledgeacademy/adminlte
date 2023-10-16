<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\Datatables;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Course;
use App\Http\Requests\FaqRequest;
use App\Http\Requests\EditFaqRequest;

class FaqController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:faq-list|faq-create|faq-edit|faq-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:faq-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:faq-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:faq-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Faq::with('creator');
            return Datatables::eloquent($query)->make(true);
        }
         return view('faq.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('faq.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FaqRequest $request)
    {
        $is_active = $request->is_active == "on" ? 1 : 0;
        $faq = Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'entity_type' => $request->entity_type,
            'entity_id' =>$request->entity_id,
            'is_active' => $is_active
        ]);
        return redirect()->route('faq.index')
            ->with('success', 'Faq created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        if($faq->entity_type=="Course"){
            $courses = Course::where('is_active', 1)->get();
            return view('faq.edit', compact('faq', 'courses'));

        }elseif($faq->entity_type=="Topic"){
            $topics = Topic::where('is_active', 1)->get();
            return view('faq.edit', compact('faq', 'topics'));
        }
        return view('faq.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditFaqRequest $request, Faq $faq)
    {
        $is_active = $request->is_active == "on" ? 1 : 0;
        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'entity_type' => $request->entity_type,
            'entity_id' =>$request->entity_id,
            'is_active' => $is_active
        ]);
        return redirect()->route('faq.index')
        ->with('success', 'FaQ updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('faq.index')
            ->with('danger', 'FaQ deleted successfully');
    }

    public function getTopicsAndCourses(Request $request) {
        $entity = $request->input('entityType');
        $options = '<option value="">Select '.$entity.'</option>';
        $options .=$entity;

        if ($entity === 'Topic') {
            $topics = Topic::all();
            foreach ($topics as $topic) {
                $options .= "<option value='{$topic->id}'>{$topic->name}</option>";
            }
        } elseif ($entity === 'Course') {
            $courses = Course::all();
            foreach ($courses as $course) {
                $options .= "<option value='{$course->id}'>{$course->name}</option>";
            }
        }
        return $options;
    }
}
