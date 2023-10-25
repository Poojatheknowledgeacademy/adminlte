<?php

namespace App\Observers;

use App\Models\Course;
use App\Helpers\LogActivity;

class CourseObserver
{
    /**
     * Handle the Course "created" event.
     */
    public function created(Course $course): void
    {
       LogActivity::addToLog('Course created -'.$course->name);
    }

    /**
     * Handle the Course "updated" event.
     */
    public function updated(Course $course): void
    {
        $originalAttributes = $course->getOriginal();
        $changedFields = [];
        foreach ($originalAttributes as $attribute => $originalValue) {
            $currentValue = $course->$attribute;
            if ($originalValue != $currentValue) {
                $changedFields[$attribute] = [
                    'old' => $originalValue,
                    'new' => $currentValue,
                ];
            }
        }

        if (!empty($changedFields)) {
            $logMessage = 'Course updated. Changed fields:';
            foreach ($changedFields as $field => $values) {
                $logMessage .= " $field (from: {$values['old']}, to: {$values['new']}) updated.";
            }
            LogActivity::addToLog($logMessage);
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
