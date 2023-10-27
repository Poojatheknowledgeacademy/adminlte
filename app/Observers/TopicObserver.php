<?php

namespace App\Observers;

use App\Models\Topic;
use App\Helpers\LogActivity;

class TopicObserver
{

    public function created(Topic $topic): void
    {
        $module = 'Topic';
        LogActivity::addToLog('Topic created: ' . $topic->name, $module, $topic->id);

    }
    public function updated(Topic $topic): void
    {
        $originalAttributes = $topic->getOriginal();
        $changedFields = [];
        foreach ($originalAttributes as $attribute => $originalValue) {
            $currentValue = $topic->$attribute;
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
        // if (!empty($changedFields)) {
        //     $logMessage = 'Topic updated.';
        //     foreach ($changedFields as $field => $values) {
        //         $logMessage .= " $field (from: {$values['old']}, to: {$values['new']}) updated.";
        //     }
        //     $module = "topic";
        //     $module_ref_id = $topic->id;
        //     LogActivity::addToLog($logMessage, $module, $module_ref_id);
        // }

        if (!empty($changedFields)) {
            $logMessage = 'Topic ';
            $updateMessage = '';

            if (array_key_exists('created_at', $changedFields)) {
                // If created_at field is in $changedFields, it's a creation
                $logMessage .= 'created.';
            } else {
                $logMessage .= 'updated.';
                foreach ($changedFields as $field => $values) {
                    $updateMessage .= "<br>$field (from: {$values['old']}, to: {$values['new']}) updated.";
                }
            }

            $module = "topic";
            $module_ref_id = $topic->id;
            LogActivity::addToLog($logMessage, $module, $module_ref_id);

            if (!empty($updateMessage)) {
                LogActivity::addToLog($updateMessage, $module, $module_ref_id);
            }
        }


        // if (!empty($changedFields)) {
        //     $logMessage = 'Topic updated. Changed fields:';
        //     foreach ($changedFields as $field => $values) {
        //         $logMessage .= " $field (from: {$values['old']}, to: {$values['new']}) updated.";
        //     }
        //     $module = "topic";
        //     $module_ref_id = $topic->id;
        //         LogActivity::addToLog($logMessage, $module, $module_ref_id);
        // }
    }
    // public function updated(Topic $topic)
    // {
    //     $originalAttributes = $topic->getOriginal();
    //     $changedFields = [];
    //     foreach ($originalAttributes as $attribute => $originalValue) {
    //         $currentValue = $topic->$attribute;
    //         if ($originalValue != $currentValue) {
    //             $changedFields[$attribute] = [
    //                 'old' => $originalValue,
    //                 'new' => $currentValue,
    //             ];
    //         }
    //     }
    //     if (!empty($changedFields)) {
    //         $logMessage = 'Topic updated. Changed fields:';
    //         foreach ($changedFields as $field => $values) {
    //             $logMessage .= " $field (from: {$values['old']}, to: {$values['new']}) updated.";
    //         }
    //         $module = "topic";
    //         $module_ref_id = $topic->id;
    //             LogActivity::addToLog($logMessage, $module, $module_ref_id);
    //     }



    // }

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
