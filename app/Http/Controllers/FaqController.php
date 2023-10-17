<?php

namespace App\Http\Controllers;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\Topic;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id)
    {
        $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $segment =$uriSegments[1];
        if ($request->ajax()) {
            $query = Faq::query();

            if ( $segment ==='topic') {
                $query->where('entity_id', $id);
                $query->where('entity_type', 'Topic');
            } elseif ( $segment === 'course') {
                $query->where('entity_id', $id);
                $query->where('entity_type', 'Course');
            }

            return Datatables::eloquent($query)->make(true);
        }
        return view('faq.list', compact('id','segment'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $segment =$uriSegments[1];
        return view('faq.create', compact('id','segment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($id,Request $request)
    {
        $entity =  Topic::findOrFail($id);
        $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $segment =$uriSegments[1];

        $entity_type = $segment == "topic" ? "Topic" : "Course";
        $is_active = $request->is_active == "on" ? 1 : 0;
        $faq = new FAQ([
            'entity_type'=> $entity_type,
            'question' => $request->question,
            'answer' => $request->answer,
            'is_active' => $is_active
        ]);
        $entity->faqs()->save($faq);
        $faq->save();
        $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        if ($uriSegments[1] === 'topic') {
            return redirect()->route('topic.faqs.index',$id)
                ->with('success', 'Faq created successfully.');

        } elseif ($uriSegments[1] === 'course') {
            return redirect()->route('course.faqs.index',$id)
            ->with('success', 'Faq created successfully.');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, Faq $faq)
    {
        $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $segment =$uriSegments[1];
        return view('faq.edit', compact('id', 'faq','segment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id,Request $request, Faq $faq)
    {
        $is_active = $request->is_active == "on" ? 1 : 0;
        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'is_active' => $is_active
        ]);
        $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        if ($uriSegments[1] === 'topic') {
            return redirect()->route('topic.faqs.index',$id)
                ->with('success', 'Faq created successfully.');

        } elseif ($uriSegments[1] === 'course') {
            return redirect()->route('course.faqs.index',$id)
            ->with('success', 'Faq created successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Faq $faq)
    {
        $faq->delete();
        $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        if ($uriSegments[1] === 'topic') {
            return redirect()->route('topic.faqs.index',$id)
                ->with('success', 'Faq created successfully.');

        } elseif ($uriSegments[1] === 'course') {
            return redirect()->route('course.faqs.index',$id)
            ->with('success', 'Faq created successfully.');
        }
    }
}
