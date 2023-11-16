<?php

namespace App\Http\Controllers\API;

use App\Models\Faq;
use App\Models\Slug;
use App\Models\Topic;
use App\Models\Course;
use App\Models\Category;
use App\Models\Topicdetail;
use App\Models\Coursedetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class StoreDataController extends Controller
{
    public function storeData(Request $request)
    {
        $json_data = file_get_contents('https://www.theknowledgeacademy.com/_engine/scripts/get-categories-topics-courses.php');
        $data = json_decode($json_data);

        if ($data->success == 1) { // Use the correct equality operator here
            $this->storeCcategories($data->categories);
        }
    }

    public function storeCcategories($categories)
    {

        foreach ($categories as $key => $value) {
            // echo "Key: " . $key . "\n";
            if (property_exists($value, 'name')) {
                $category = Category::updateOrCreate([
                    'name' => $value->name,
                    'tka_id' => $key
                ]);
                // echo "Category TKA_ID: " . $category->tka_id;
                $this->storeTopics($value->topic, $category->id);
            }
        }
    }

    public function storeTopics($topics, $category_id)
    {
        foreach ($topics as $topic => $topicvalue) {
            // echo "topics: " . $topic . "\n";
            if (property_exists($topicvalue, 'name')) {
                // print_r($topicvalue);
                $topic = Topic::updateOrCreate([
                    'name' => $topicvalue->name,
                    'tka_id' => $topic,
                    'category_id' => $category_id,
                ]);
                //  echo "course TKA_ID: " . $topic->tka_id;
                //if (property_exists($topicvalue->courses, 'courses')) {

                $this->storeCourses($topicvalue->courses, $topic->id);
                $this->storeTopicsFaq($topicvalue->faq, $topic);
                $this->topicdetails($topicvalue, $topic->id);
                $this->storeTopicSlugs($topicvalue, $topic);
            }
        }
    }

    public function storeTopicsFaq($topicfaq, $topic)
    {
        foreach ($topicfaq as $faqitem) {
            //  echo "coursefaq: " . $coursefaq . "\n";
            $topic->faqs()->updateOrCreate([
                'question' => $faqitem->question,
                'answer' => $faqitem->answer,
            ]);
        }

        // }
    }

    public function storeCourses($course, $topic_id)
    {

        foreach ($course as $key => $value) {

            $course = Course::updateOrCreate([
                'name' => $value->name,
                'tka_id' => $key,
                'topic_id' => $topic_id,

            ]);
            if (isset($value->faq)) {
                $this->storeTopicsFaq($value->faq, $course);
                $this->Coursedetail($value, $course->id);
                $this->storeCourseSlugs($value, $course);
            }
        }
    }

    public function storeCourseFaq($coursefaq, $course)
    {
        foreach ($coursefaq as $faqitem) {
            //  echo "coursefaq: " . $coursefaq . "\n";
            $course->faqs()->updateOrCreate([
                'question' => $faqitem->question,
                'answer' => $faqitem->answer,
            ]);
        }
    }
    public function topicdetails($topicdetails, $topic_id)
    {

        Topicdetail::updateOrCreate([

            'country_id' => 1,
            'summary' => $topicdetails->summary,
            'overview' => $topicdetails->overview,
            'meta_keywords' => $topicdetails->topicMetaKeywords,
            'meta_description' => $topicdetails->topicMetaDesc,
            'meta_title' => $topicdetails->topicMetaTitle,
            'who_should_attend' => $topicdetails->whyChoose,
            'heading' => $topicdetails->h1,
            'topic_id' => $topic_id,
        ]);
    }

    public function CourseDetail($coursesvalue, $courseid)
    {
        CourseDetail::updateOrCreate(
            ['course_id' => $courseid],
            [
                'country_id' => 1,
                'heading' => $coursesvalue->h1,
                'summary' => $coursesvalue->overviewBulletList,
                'detail' => $coursesvalue->outline,
                'overview' => $coursesvalue->overview,
                'whats_included' => $coursesvalue->whatsincluded,
                'who_should_attend' => $coursesvalue->audience,
                'meta_title' => $coursesvalue->courseMetaTitle,
                'meta_keywords' => $coursesvalue->courseMetaKeywords,
                'meta_description' => $coursesvalue->courseMetaDesc,
                'duration' => $coursesvalue->duration,
                'pdu' => $coursesvalue->pdu,
                'audience' => $coursesvalue->audience,
                'accreditationId' => $coursesvalue->accreditationId,
                'exam_included' => $coursesvalue->examIncluded
            ]
        );
    }
    public function storeTopicSlugs($topicvalue, $topic)
    {

        $topic->slugs()->updateOrCreate([

            'entity_id' => $topic->id,
            'slug' => $topicvalue->topicURL,
        ]);
    }
    public function storeCourseSlugs($value, $course)
    {

        $course->slugs()->updateOrCreate([

            'entity_id' => $course->id,
            'slug' => $value->courseURL,
        ]);
    }
}
