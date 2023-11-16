<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Topic;
use App\Models\Coursedetail;
use Illuminate\Http\Request;
use App\Models\Topicdetail;
use Illuminate\Support\Facades\Auth;

class Get_DataController extends Controller
{
    public function __construct()
    {
        ini_set('max_execution_time', 1000);
    }
    public function data()
    {
        $json_data = file_get_contents('https://www.theknowledgeacademy.com/_engine/scripts/get-categories-topics-courses.php');
        $data = json_decode($json_data);

        if ($data->success == 1) {
            $this->storeCategories($data->categories);
        }
    }
    public function storeCategories($categories)
    {
        foreach ($categories as $tka_id => $category) {
            if ($tka_id) {
                $category_obj = Category::updateOrCreate(
                    ['tka_id' => $tka_id],
                    [
                        'name' => $category->name,
                        'created_by' => Auth::guard('api')->user()->id
                    ]
                );
                $this->storeTopics($category->topic, $category_obj->id);
            }
        }
    }
    public function storeTopics($topics, $category_id)
    {
        foreach ($topics as  $tka_id => $topic) {
            if ($tka_id) {
                $topic_obj = Topic::updateOrCreate(
                    ['tka_id' => $tka_id],
                    [
                        'name' => $topic->name,
                        'category_id' => $category_id,
                        'created_by' => Auth::guard('api')->user()->id
                    ]
                );
                $this->storeTopicSlug($topic, $topic_obj);
                $this->storeTopicsDetail($topic, $topic_obj);
                $this->storeCourses($topic->courses, $topic_obj->id);
            }
        }
    }
    public function storeTopicSlug($topic, $topic_obj)
    {
        $topic_obj->slugs()->updateOrCreate(
            [
                'entity_id' => $topic_obj->id
            ],
            [
                'slug' => $topic->topicURL,
            ]
        );
    }
    public function storeTopicsDetail($topic, $topic_obj)
    {
        Topicdetail::updateOrCreate(
            ['topic_id' =>  $topic_obj->id],
            [
                'country_id' => 1,
                'heading' => $topic->h1,
                'summary' => $topic->summary,
                'overview' => $topic->overview,
                'who_should_attend' => $topic->whyChoose,
                'meta_title' => $topic->topicMetaTitle,
                'meta_keywords' => $topic->topicMetaKeywords,
                'meta_description' => $topic->topicMetaDesc,
                'added_by' => Auth::guard('api')->user()->id
            ]
        );
        if (!empty($topic->faq)) {
            $this->storeTopicFaq($topic->faq, $topic_obj);
        }
    }
    public function storeTopicFaq($faqs, $topic_obj)
    {
        foreach ($faqs as  $faq) {
            if (!empty($faq->question)) {
                $topic_obj->faqs()->updateOrCreate(
                    [
                        'question' => $faq->question
                    ],
                    [
                        'answer' => $faq->answer,
                        'created_by' => Auth::guard('api')->user()->id
                    ]
                );
            }
        }
    }
    public function storeCourses($courses, $topic_id)
    {
        foreach ($courses  as  $tka_id =>  $course) {
            $course_obj = Course::updateOrCreate(
                ['tka_id' => $tka_id],
                [
                    'name' => $course->name,
                    'topic_id' => $topic_id,
                    'is_active' => $course->isHidden,
                    'parentCourseId' => $course->parentCourseId,
                    'url' => $course->url,
                    'coursecode' => $course->courseCode,
                    'is_weekend' => $course->isWeekend,
                    'is_module' => $course->isModule,
                    'is_technical' => $course->isTechnical,
                    'created_by' => Auth::guard('api')->user()->id
                ]
            );
            $this->storeCourseSlug($course, $course_obj);
            $this->storeCourseDetail($course, $course_obj);
        }
    }
    public function storeCourseSlug($course, $course_obj)
    {
        $course_obj->slugs()->updateOrCreate(
            ['entity_id' => $course_obj->id],
            [
                'slug' => $course->courseURL,
            ]
        );
    }
    public function storeCourseDetail($course, $course_obj)
    {
        CourseDetail::updateOrCreate(
            ['course_id' => $course_obj->id],
            [
                'country_id' => 1,
                'heading' => $course->h1,
                'summary' => $course->overviewBulletList,
                'detail' => $course->outline,
                'overview' => $course->overview,
                'whats_included' => $course->whatsincluded,
                'who_should_attend' => $course->audience,
                'meta_title' => $course->courseMetaTitle,
                'meta_keywords' => $course->courseMetaKeywords,
                'meta_description' => $course->courseMetaDesc,
                'duration' => $course->duration,
                'pdu' => $course->pdu,
                'audience' => $course->audience,
                'accreditationId' => $course->accreditationId,
                'exam_included' => $course->examIncluded,
                'added_by' => Auth::guard('api')->user()->id
            ]
        );
        if (!empty($course->faq)) {
            $this->storeCourseFaq($course->faq, $course_obj);
        }
    }
    public function storeCourseFaq($faqs, $course_obj)
    {
        foreach ($faqs as  $faq) {
            if (!empty($faq->question)) {
                $course_obj->faqs()->updateOrCreate(
                    [
                        'question' => $faq->question
                    ],
                    [
                        'answer' => $faq->answer,
                        'created_by' => Auth::guard('api')->user()->id
                    ]
                );
            }
        }
    }
}
