<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        $category->logActivities()->create([
            'activity' => 'Category ' . $category->name . ' created',
        ]);
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        $originalAttributes = $category->getOriginal();

        foreach ($originalAttributes as $attribute => $originalValue) {
            $currentValue = $category->$attribute;

            if ($attribute === 'updated_at' && $originalValue != $currentValue) {
                continue;
            }

            if ($attribute == 'name' && $originalValue != $currentValue) {
                $category->logActivities()->create([
                    'activity' => "Category Name updated from {$originalValue} to {$currentValue}",
                ]);
            }

            if ($attribute === 'is_active') {
                if ($originalValue == 0 && $currentValue == 1) {
                    $category->logActivities()->create([
                        'activity' => 'category status Deactivate to Activated',
                    ]);
                } elseif ($originalValue == 1 && $currentValue == 0) {
                    $category->logActivities()->create([
                        'activity' => 'category status Activate to Deactivated',
                    ]);
                }
            }
            if ($attribute === 'is_popular') {
                if ($originalValue == 0 && $currentValue == 1) {
                    $category->logActivities()->create([
                        'activity' => 'category popular off to on',
                    ]);
                } elseif ($originalValue == 1 && $currentValue == 0) {
                    $category->logActivities()->create([
                        'activity' => 'category popular on to off',
                    ]);
                }
            }
            if ($attribute === 'is_technical') {
                if ($originalValue == 0 && $currentValue == 1) {
                    $category->logActivities()->create([
                        'activity' => 'category technical off to on',
                    ]);
                } elseif ($originalValue == 1 && $currentValue == 0) {
                    $category->logActivities()->create([
                        'activity' => 'category technical on to off',
                    ]);
                }
            }
        }
    }



    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        // You can add code here to handle the "deleted" event.
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        // You can add code here to handle the "restored" event.
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        // You can add code here to handle the "force deleted" event.
    }
}
