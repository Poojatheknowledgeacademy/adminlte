<?php

namespace App\Observers;

use App\Models\Category;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Auth;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        $category->logActivities()->create([
            'activity' => $category->name . ' created',
            'created_by' => Auth::user()->id,
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
                    'created_by' => Auth::user()->id,
                ]);
            }
            // Add more conditionals for other attributes as needed
        }
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        // You can add log entries for deletions here if needed.
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        // You can add log entries for restorations here if needed.
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        // You can add log entries for force deletions here if needed.
    }
}
