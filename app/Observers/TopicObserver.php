<?php

namespace App\Observers;

use App\Models\Topic;
use App\Models\Category;

class TopicObserver
{
    public function created(Topic $topic): void
    {
        $topic->logActivities()->create([
            'activity' => "Topic created " . $topic->name,
        ]);
    }

    public function updated(Topic $topic): void
    {
        $originalAttributes = $topic->getOriginal();

        foreach ($originalAttributes as $attribute => $originalValue) {
            $currentValue = $topic->$attribute;
            if ($attribute === 'updated_at' && $originalValue != $currentValue) {
                continue;
            }
            if ($attribute == 'name' && $originalValue != $currentValue) {
                $topic->logActivities()->create([
                    'activity' => "Topic Name updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'category_id' && $originalValue != $currentValue) {
                $oldCategoryName = Category::find($originalValue)->name;
                $newCategoryName = Category::find($currentValue)->name;
                $topic->logActivities()->create([
                    'activity' => "Topic category updated from {$oldCategoryName} to {$newCategoryName}",
                ]);
            }
            if ($attribute == 'logo' && $originalValue != $currentValue) {
                $topic->logActivities()->create([
                    'activity' => "Topic Logo Updated",
                ]);
            }
            if ($attribute === 'is_active') {
                if ($originalValue == 0 && $currentValue == 1) {
                    $topic->logActivities()->create([
                        'activity' => 'Topic status Deactivate to Activated',
                    ]);
                } elseif ($originalValue == 1 && $currentValue == 0) {
                    $topic->logActivities()->create([
                        'activity' => 'Topic status Activate to Deactivated',
                    ]);
                }
            }
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
