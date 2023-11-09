<?php

namespace App\Observers;

use App\Models\Course;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;

class CourseObserver
{

    /**
     * Handle the Course "created" event.
     */
    public function created(Course $course): void
    {
       //$created_by = Auth::user()->id ?? NULL;
        $course->logActivities()->create([
            'activity' => 'Course '.$course->name.' created',
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
                ]);
            }
            if ($attribute == 'topic_id' && $originalValue != $currentValue) {
                $oldTopicName = Topic::find($originalValue)->name;
                $newTopicName = Topic::find($currentValue)->name;
                $course->logActivities()->create([
                    'activity' =>"Course Topic updated from {$oldTopicName} to {$newTopicName}",
                ]);
            }
            if ($attribute == 'logo' && $originalValue != $currentValue) {
                $course->logActivities()->create([
                    'activity' =>"Course Logo Updated",
                ]);
            }
            if ($attribute == 'is_active' && $originalValue != $currentValue) {
                if ($originalValue == 0 && $currentValue == 1) {
                    $course->logActivities()->create([
                        'activity' => 'Course status Deactivate to Activated',
                    ]);
                } elseif ($originalValue == 1 && $currentValue == 0) {
                    $course->logActivities()->create([
                        'activity' => 'Course status Activate to Deactivated',
                    ]);
                }
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
