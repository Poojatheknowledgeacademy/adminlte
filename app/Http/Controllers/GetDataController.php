<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Course;
use App\Models\Category;
use App\Models\Topicdetail;
use App\Models\Coursedetail;
use Illuminate\Support\Facades\Auth;

class GetDataController extends Controller
{
    public function __construct()
    {
        ini_set('max_execution_time', 300);
    }
    public function data()
    {
        $json_data = file_get_contents('https://www.theknowledgeacademy.com/_engine/scripts/get-categories-topics-courses.php');
        $data = json_decode($json_data);
        if (isset($data)) {
            $this->storeCategories($data->categories);
        }
    }
    public function storeCategories($categories)
    {
        foreach ($categories as $tkaid => $category) {
            if (isset($category->name)) {
                $category_obj = Category::firstOrCreate(
                    ['tka_id' => $tkaid],
                    [
                        'name' => $category->name,
                        'created_by' => Auth::guard('api')->user()->id
                    ]
                );
                if (isset($category->topic)) {
                    $this->storeTopics($category->topic, $category_obj->id);
                }
            }
            $category_obj->save();
        }
    }
    public function storeTopics($topics, $category_id)
    {
        foreach ($topics as $tkaid => $topic) {
            $topic_obj = $this->createTopic($topic, $tkaid, $category_id);
            $this->createTopicSlugs($topic_obj, $topic->topicURL);
            $this->createTopicFaqs($topic_obj, $topic);
            $this->createTopicDetail($topic_obj, $topic);
            if (isset($topic->courses)) {
                $this->storeCourses($topic->courses, $topic_obj->id);
            }
        }
    }
    public function storeCourses($courses, $topic_id)
    {
        foreach ($courses as $tkaid => $course) {
            $course_obj = $this->createCourse($course, $tkaid, $topic_id);
            $this->createCourseSlugs($course_obj, $course->courseURL);
            if (isset($course->faq)) {
                $this->createCourseFaqs($course_obj, $course->faq);
            }
            $this->createCourseDetail($course_obj, $course);
        }
    }
    protected function createTopic($topic, $tkaid, $category_id)
    {
        return Topic::firstOrCreate(
            ['tka_id' => $tkaid],
            [
                'name' => $topic->name,
                'category_id' => $category_id,
                'created_by' => Auth::guard('api')->user()->id
            ]
        );
    }
    protected function createTopicSlugs($topic_obj, $slug)
    {
        $topic_obj->slugs()->firstOrCreate(
            ['slug' => $slug]
        );
    }
    protected function createTopicFaqs($topic_obj, $topic)
    {
        foreach ($topic->faq as $topic_faq) {
            if (isset($topic_faq->question)) {
                $topic_obj->faqs()->firstOrCreate(
                    ['question' => $topic_faq->question],
                    [
                        'answer' => $topic_faq->answer,
                        'is_active' => 1,
                        'created_by' => Auth::guard('api')->user()->id
                    ]
                );
            }
        }
    }
    protected function createTopicDetail($topic_obj, $topic)
    {
        TopicDetail::firstOrCreate(
            ['topic_id' => $topic_obj->id],
            [
                'country_id' => 1,
                'heading' => $topic->h1,
                'summary' => $topic->summary,
                'overview' => $topic->overview,
                'who_should_attend' => $topic->benefitsIndividual,
                'meta_title' => $topic->topicMetaTitle,
                'meta_keywords' => $topic->topicMetaKeywords,
                'meta_description' => $topic->topicMetaDesc,
                'added_by' => Auth::guard('api')->user()->id
            ]
        );
    }
    protected function createCourse($course, $tkaid, $topic_id)
    {
        return Course::firstOrCreate(
            ['tka_id' => $tkaid],
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
    }
    protected function createCourseSlugs($course_obj, $slug)
    {
        $course_obj->slugs()->firstOrCreate(
            ['slug' => $slug]
        );
    }
    protected function createCourseFaqs($course_obj, $course)
    {
        foreach ($course as $course_faq) {
            if (isset($course_faq->question)) {
                $course_obj->faqs()->firstOrCreate(
                    ['question' => $course_faq->question],
                    [
                        'answer' => $course_faq->answer,
                        'is_active' => 1,
                        'created_by' => Auth::guard('api')->user()->id
                    ]
                );
            }
        }
    }
    protected function createCourseDetail($course_obj, $course)
    {
        Coursedetail::firstOrCreate(
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
    }
}
