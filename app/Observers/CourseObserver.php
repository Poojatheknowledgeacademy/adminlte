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
        $module = "course";
        LogActivity::addToLog('Course created -' . $course->name, $module, $course->id);
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
            if ($attribute === 'updated_at' && $originalValue != $currentValue) {
                continue;
            }
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
            $module = "course";
            $module_ref_id = $course->id;
                LogActivity::addToLog($logMessage, $module, $module_ref_id);
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
