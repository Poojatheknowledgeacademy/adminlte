<?php

namespace App\Observers;

use App\Models\Blog;
use App\Helpers\LogActivity;

class BlogObserver
{

    /**
     * Handle the Blog "created" event.
     */
    public function created(Blog $blog): void
    {
        $module = "blog";
        LogActivity::addToLog('Created ' . $blog->title, $module, $blog->id);
    }

    /**
     * Handle the Blog "updated" event.
     */
    public function updated(Blog $blog): void
    {
        $originalAttributes = $blog->getOriginal();
        $changedFields = [];
        foreach ($originalAttributes as $attribute => $originalValue) {
            $currentValue = $blog->$attribute;
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

            $module = "blog";
            $module_ref_id = $blog->id;
            LogActivity::addToLog(nl2br($logMessage), $module, $module_ref_id);
        }
    }

    /**
     * Handle the Blog "deleted" event.
     */
    public function deleted(Blog $blog): void
    {
        // You can add log entries for deletions here if needed.
    }

    /**
     * Handle the Blog "restored" event.
     */
    public function restored(Blog $blog): void
    {
        // You can add log entries for restorations here if needed.
    }

    /**
     * Handle the Blog "force deleted" event.
     */
    public function forceDeleted(Blog $blog): void
    {
        // You can add log entries for force deletions here if needed.
    }
}
