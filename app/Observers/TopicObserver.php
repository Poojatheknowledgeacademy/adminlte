<?php

namespace App\Observers;
use App\Models\Topic;
use App\Helpers\LogActivity;
class TopicObserver
{

    public function created(Topic $topic): void
    {
        LogActivity::addToLog('Topic created: ' . $topic->name);;
    }

    public function updated(Topic $topic)
    {
        $originalAttributes = $topic->getOriginal();
        $changedFields = [];
        foreach ($originalAttributes as $attribute => $originalValue) {
            $currentValue = $topic->$attribute;
            if ($originalValue != $currentValue) {
                $changedFields[$attribute] = [
                    'old' => $originalValue,
                    'new' => $currentValue,
                ];
            }
        }
        if (!empty($changedFields)) {
            $logMessage = 'Topic updated. Changed fields:';
            foreach ($changedFields as $field => $values) {
                $logMessage .= " $field (from: {$values['old']}, to: {$values['new']}) updated.";
            }
            LogActivity::addToLog($logMessage);
        }
    }

    /**
     * Handle the Topic "deleted" event.
     */
    public function deleted(Topic $topic): void
    {
        //
    }

    /**
     * Handle the Topic "restored" event.
     */
    public function restored(Topic $topic): void
    {
        //
    }

    /**
     * Handle the Topic "force deleted" event.
     */
    public function forceDeleted(Topic $topic): void
    {
        //
    }
}
