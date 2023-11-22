<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Country;
use App\Models\Topicdetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use App\Http\Requests\TopicDetailRequest;
use App\Http\Requests\EditTopicdetailRequest;
use Illuminate\Support\Facades\Auth;

class TopicDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id)
    {
        if ($request->ajax()) {
            $query = Topicdetail::with('country', 'topic');
            $query->where('topic_id', $id);
            $query->where('country_id', session('country')->id);
            return Datatables::eloquent($query)->make(true);
        }
        return view('topic.detail.list', compact('id'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $topics = Topic::where('is_active', 1)->get();
        $countries = Country::get();
        return view('topic.detail.create', compact('id', 'topics', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($id, TopicDetailRequest $request)

    {
        Topicdetail::create([
            'topic_id' =>  $request->topic_id,
            'country_id' => $request->country,
            'heading' => $request->heading,
            'summary' => $request->summary,
            'detail' => $request->detail,
            'overview' => $request->overview,
            'whats_included' => $request->whats_included,
            'pre_requisite' => $request->pre_requisite,
            'who_should_attend' => $request->who_should_attend,
            'added_by' => $request->added_by,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'created_by' => Auth::user()->id
        ]);


        return redirect()->route('topic.topicdetails.index', $request->topic_id)
            ->with('success', 'Topic Detail created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TopicDetail $topicDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, Topicdetail $topicdetail)
    {
        $topics = Topic::where('is_active', 1)->get();
        $countries = Country::get();
        return view('topic.detail.edit', compact('id', 'topicdetail', 'topics', 'countries'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update($id, EditTopicdetailRequest $request, Topicdetail $topicdetail)
    {
        $topicdetail->update([
            'topic_id' =>  $request->topic_id,
            'country_id' => $request->country_id,
            'heading' => $request->heading,
            'summary' => $request->summary,
            'detail' => $request->detail,
            'overview' => $request->overview,
            'whats_included' => $request->whats_included,
            'pre_requisite' => $request->pre_requisite,
            'who_should_attend' => $request->who_should_attend,
            'added_by' => $request->added_by,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description

        ]);

        return redirect()->route('topic.topicdetails.index', $topicdetail->topic_id)
            ->with('success', 'Topic Detail Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Topicdetail $topicdetail)
    {
        $topicdetail->delete();
        return redirect()->route('topic.topicdetails.index', $topicdetail->topic_id)
            ->with('danger', 'Topic Detail deleted successfully');
    }

    public function trashedTopicDetail(Request $request)
    {
        if ($request->ajax()) {
            $trashedTopicDetails = TopicDetail::onlyTrashed();
            return Datatables::eloquent($trashedTopicDetails)->make(true);
        }
        return view('trash.topicdetail_list');
    }


    public function restore($id)
    {
        $topicDetail = TopicDetail::withTrashed()->findOrFail($id);
        $topicDetail->restore();
        session()->flash('success', 'TopicDetail Restored successfully.');
        return redirect()->route('topic.topicdetails.index', $topicDetail->topic_id);
    }

    public function delete($id)
    {
        $topicDetail = TopicDetail::withTrashed()->findOrFail($id);
        $topicDetail->forceDelete();
        session()->flash('danger', 'TopicDetail Deleted successfully.');
        return redirect()->route('trashedTopicDetail');
    }
}
