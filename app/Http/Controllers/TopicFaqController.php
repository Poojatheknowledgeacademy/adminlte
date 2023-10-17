<?php

namespace App\Http\Controllers;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\Topic;

class TopicFaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,$topic_id)
    {
        if ($request->ajax()) {
            $query = Faq::query();
            $query->where('entity_id', $topic_id);
            $query->where('entity_type', 'Topic');
            return Datatables::eloquent($query)->make(true);
        }
        return view('topic.faq.list', compact('topic_id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($topic_id)
    {
        return view('topic.faq.create', compact('topic_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($topic_id,Request $request)
    {
        $entity =  Topic::findOrFail($topic_id);

        $is_active = $request->is_active == "on" ? 1 : 0;
        $faq = new FAQ([
            'entity_type'=>'Topic',
            'question' => $request->question,
            'answer' => $request->answer,
            'is_active' => $is_active
        ]);
        $entity->faqs()->save($faq);
        $faq->save();

        return redirect()->route('topic.faqs.index',$topic_id)
            ->with('success', 'Faq created successfully.');
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
    public function edit($topic_id, Faq $faq)
    {
        return view('topic.faq.edit', compact('topic_id', 'faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($topic_id,Request $request, Faq $faq)
    {
        $is_active = $request->is_active == "on" ? 1 : 0;
        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'is_active' => $is_active
        ]);
        return redirect()->route('topic.faqs.index', $topic_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($topic_id, Faq $faq)
    {
        $faq->delete();
        return redirect()->route('topic.faqs.index', $topic_id);
    }
}
