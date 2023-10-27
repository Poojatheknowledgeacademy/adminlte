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
        LogActivity::addToLog('Created ' . $course->name, $module, $course->id);
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
            $logMessage = 'update ';
            foreach ($changedFields as $field => $values) {
                $logMessage .= "$field From {$values['old']} to {$values['new']} ,";
            }
            $logMessage = rtrim($logMessage, ',') . '.';



            $module = "course";
            $module_ref_id = $course->id;
            LogActivity::addToLog(nl2br($logMessage), $module, $module_ref_id);
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
