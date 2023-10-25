<?php

namespace App\Observers;
use App\Models\Blog;
use App\Helpers\LogActivity;

class BlogObserver
{
    /**
     * Handle the Course "created" event.
     */
    public function created(Blog $blog): void
    {
       LogActivity::addToLog('Blog created -'.$blog->title);
    }

    /**
     * Handle the Course "updated" event.
     */
    public function updated(Blog $blog): void
    {
        $originalAttributes = $blog->getOriginal();
        $changedFields = [];
        foreach ($originalAttributes as $attribute => $originalValue) {
            $currentValue = $blog->$attribute;
            if ($originalValue != $currentValue) {
                $changedFields[$attribute] = [
                    'old' => $originalValue,
                    'new' => $currentValue,
                ];
            }
        }

        if (!empty($changedFields)) {
            $logMessage = 'Blog updated. Changed fields:';
            foreach ($changedFields as $field => $values) {
                $logMessage .= " $field (from: {$values['old']}, to: {$values['new']}) updated.";
            }
            LogActivity::addToLog($logMessage);
        }
    }

    /**
     * Handle the Course "deleted" event.
     */
    public function deleted(Blog $course): void
    {
        //
    }

    /**
     * Handle the Course "restored" event.
     */
    public function restored(Blog $course): void
    {
        //
    }

    /**
     * Handle the Course "force deleted" event.
     */
    public function forceDeleted(Blog $course): void
    {
        //
    }

}
