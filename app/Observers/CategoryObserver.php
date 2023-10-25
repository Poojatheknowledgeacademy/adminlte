<?php

namespace App\Observers;

use App\Models\Category;
use App\Helpers\LogActivity;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        LogActivity::addToLog('Category created - ' . $category->name);
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        $originalAttributes = $category->getOriginal();
        $changedFields = [];
        foreach ($originalAttributes as $attribute => $originalValue) {
            $currentValue = $category->$attribute;
            if ($originalValue != $currentValue) {
                $changedFields[$attribute] = [
                    'old' => $originalValue,
                    'new' => $currentValue,
                ];
            }
        }

        if (!empty($changedFields)) {
            $logMessage = 'Category updated. Changed fields:';
            foreach ($changedFields as $field => $values) {
                $logMessage .= " $field (from: {$values['old']}, to: {$values['new']}) updated.";
            }
            LogActivity::addToLog($logMessage);
        }
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        LogActivity::addToLog('Category deleted - ' . $category->name);
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        LogActivity::addToLog('Category restored - ' . $category->name);
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        LogActivity::addToLog('Category force deleted - ' . $category->name);
    }
}
