<?php

namespace App\Http\Controllers\API;

use App\Models\Topic;
use App\Models\Course;
use App\Models\Category;
use App\Models\Topicdetail;
use App\Models\Coursedetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StoreDataController extends Controller
{
    public function __construct()
    {
        ini_set('max_execution_time', 600);
    }
    public function Storedata()
    {
        $json_data = file_get_contents('https://www.theknowledgeacademy.com/_engine/scripts/get-categories-topics-courses.php');
        $data = json_decode($json_data);
        if ($data->success = 1) {
            $this->storeCcategories($data->categories);
        }
    }
    public function storeCcategories($categories)
    {
        foreach ($categories as $key => $value) {
            if (property_exists($value, 'name')) {
                $category = Category::updateOrCreate(
                    ['tka_id' => $key],
                    [
                        'name' => $value->name,
                        'created_by' => Auth::guard('api')->user()->id
                    ]

                );
                $categoryid = $category->id;
                $this->storeTopics($categoryid, $value->topic);
            }
        }
    }
    public function storeTopics($categoryid, $topics)
    {
        foreach ($topics as $topic => $topicvalue) {
            if (property_exists($topicvalue, 'name')) {
                $topic = Topic::updateOrCreate(
                    ['tka_id' => $topic],
                    [
                        'name' => $topicvalue->name,
                        'category_id' => $categoryid,
                        'created_by' => Auth::guard('api')->user()->id

                    ]
                );
                $topic->slugs()->updateOrCreate(
                    ['entity_id' => $topic->id],
                    [
                        'slug' => $topicvalue->topicURL,
                    ]
                );
                $this->storetopicdetails($topicvalue, $topic->id);

                if (isset($topicvalue->faq)) {

                    $this->storetopicfaq($topicvalue->faq, $topic);
                }
                $this->storecourse($topicvalue->courses, $topic->id);
            }
        }
    }
    public function storetopicdetails($topicvalue, $topicid)
    {
        Topicdetail::updateOrCreate(
            ['topic_id' => $topicid],
            [
                'meta_title' => $topicvalue->topicMetaTitle,
                'meta_description' => $topicvalue->topicMetaDesc,
                'meta_keywords' => $topicvalue->topicMetaKeywords,
                'summary' => $topicvalue->summary,
                'overview' => $topicvalue->overview,
                'who_should_attend' => $topicvalue->whyChoose,
                'heading' => $topicvalue->h1,
                'added_by' => Auth::guard('api')->user()->id,
                'country_id' => 1
            ]
        );
    }
    public function storetopicfaq($topicfaq, $topic)
    {
        foreach ($topicfaq as $faqItem) {
            if (isset($faqItem->question)) {
                $topic->faqs()->updateOrCreate(
                    ['question' => $faqItem->question],
                    [
                        'answer' =>  $faqItem->answer,
                        'created_by' => Auth::guard('api')->user()->id
                    ]
                );
            }
        }
    }

    public function storecourse($courses, $topicid)
    {
        foreach ($courses as $coursesItem => $coursesvalue) {
            $course = Course::updateOrCreate(
                ['tka_id' => $coursesItem],
                [
                    'topic_id' => $topicid,
                    'name' => $coursesvalue->name,
                    'is_active' => $coursesvalue->isHidden,
                    'parentCourseId'=> $coursesvalue->parentCourseId,
                    'url'=> $coursesvalue->url,
                    'coursecode'=> $coursesvalue->courseCode,
                    'is_weekend' => $coursesvalue->isWeekend,
                    'is_module' => $coursesvalue->isModule,
                    'is_technical' => $coursesvalue->isTechnical,
                    'created_by' => Auth::guard('api')->user()->id
                ]
            );

            $course->slugs()->updateOrCreate(
                ['entity_id' => $course->id],
                [
                    'slug' => $coursesvalue->courseURL,
                ]
            );
            $this->storecoursedetails($coursesvalue, $course->id);
            if (isset($coursesvalue->faq->question)) {
                $this->storecoursefaq($coursesvalue->faq, $course);
            }
        }
    }
    public function storecoursedetails($coursesvalue, $courseid)
    {
        Coursedetail::updateOrCreate(
            ['course_id' => $courseid],
            [
                'meta_title' => $coursesvalue->courseMetaTitle,
                'meta_description' => $coursesvalue->courseMetaDesc,
                'meta_keywords' => $coursesvalue->courseMetaKeywords,
                'summary' => $coursesvalue->overviewBulletList,
                'overview' => $coursesvalue->overview,
                'whats_included' => $coursesvalue->whatsincluded,
                'heading' => $coursesvalue->h1,
                'detail' => $coursesvalue->outline,
                'added_by' => Auth::guard('api')->user()->id,
                'duration' => $coursesvalue->duration,
                'pdu' => $coursesvalue->pdu,
                'audience' => $coursesvalue->audience,
                'accreditationId' => $coursesvalue->accreditationId,
                'exam_included' => $coursesvalue->examIncluded,
                'country_id' => 1
            ]
        );
    }
    public function storecoursefaq($coursefaq, $course)
    {
        foreach ($coursefaq as $faqItem) {
            $course->faqs()->updateOrCreate(
                ['question' => $faqItem->question],
                [

                    'answer' =>  $faqItem->answer,
                    'created_by' => Auth::guard('api')->user()->id
                ]
            );
        }
    }
}
