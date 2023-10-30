<?php

namespace App\Observers;

use App\Models\Module;
use App\Models\Topic;

class ModuleObserver
{
    /**
     * Handle the Module "created" event.
     */
    public function created(Module $module): void

    {
        $module->logActivities()->create([
            'activity' => $module->name . ' created'
        ]);
    }

    /**
     * Handle the Module "updated" event.
     */
    public function updated(Module $module): void
    {
        $originalAttributes = $module->getOriginal();

        foreach ($originalAttributes as $attribute => $originalValue) {
            $currentValue = $module->$attribute;
            if ($attribute === 'updated_at' && $originalValue != $currentValue) {
                continue;
            }
            if ($attribute == 'name' && $originalValue != $currentValue) {
                $module->logActivities()->create([
                    'activity' => "Module Name updated from {$originalValue} to {$currentValue}"
                ]);
            }
            // Add more conditionals for other attributes as needed
        }
    }

    /**
     * Handle the Module "deleted" event.
     */
    public function deleted(Module $module): void
    {
        // You can add log entries for deletions here if needed.
    }

    /**
     * Handle the Module "restored" event.
     */
    public function restored(Module $module): void
    {
        // You can add log entries for restorations here if needed.
    }

    /**
     * Handle the Module "force deleted" event.
     */
    public function forceDeleted(Module $module): void
    {
        // You can add log entries for force deletions here if needed.
    }
}
