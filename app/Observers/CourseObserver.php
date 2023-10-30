<?php

namespace App\Observers;

use App\Models\Course;
use App\Helpers\LogActivity;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;

class CourseObserver
{

    /**
     * Handle the Course "created" event.
     */
    public function created(Course $course): void
    {
        $course->logActivities()->create([
            'activity' => $course->name.' created',
            'created_by'=>Auth::user()->id
        ]);
    }

    /**
     * Handle the Course "updated" event.
     */
    public function updated(Course $course): void
    {
        $originalAttributes = $course->getOriginal();

        foreach ($originalAttributes as $attribute => $originalValue) {
            $currentValue = $course->$attribute;
            if ($attribute === 'updated_at' && $originalValue != $currentValue) {
                continue;
            }
            if ($attribute == 'name' && $originalValue != $currentValue) {
                $course->logActivities()->create([
                    'activity' =>"Course Name updated from {$originalValue} to {$currentValue}",
                    'created_by'=>Auth::user()->id
                ]);
            }
            if ($attribute == 'topic_id' && $originalValue != $currentValue) {
                $oldTopicName = Topic::find($originalValue)->name;
                $newTopicName = Topic::find($currentValue)->name;
                $course->logActivities()->create([
                    'activity' =>"Topic updated from {$oldTopicName} to {$newTopicName}",
                    'created_by'=>Auth::user()->id
                ]);
            }
            if ($attribute == 'logo' && $originalValue != $currentValue) {
                $course->logActivities()->create([
                    'activity' =>"Course Logo Updated",
                    'created_by'=>Auth::user()->id
                ]);
            }
            if ($attribute == 'is_active' && $originalValue != $currentValue) {
                $course->logActivities()->create([
                    'activity' =>  "Activity Updated",
                    'created_by'=>Auth::user()->id
                ]);
            }
        }
    }

    /**
     * Handle the Course "deleted" event.
     */
    public function deleted(Course $course): void
    {
        //
    }

    /**
     * Handle the Course "restored" event.
     */
    public function restored(Course $course): void
    {
        //
    }

    /**
     * Handle the Course "force deleted" event.
     */
    public function forceDeleted(Course $course): void
    {
        //
    }
}
