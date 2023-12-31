<?php

namespace App\Observers;

use App\Models\Module;

class ModuleObserver
{
    /**
     * Handle the Module "created" event.
     */
    public function created(Module $module): void
    {
        $module->logActivities()->create([
            'activity' => 'Module ' . $module->name . ' created',
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
                    'activity' => "Module Name updated from {$originalValue} to {$currentValue}",
                ]);
            }

            if ($attribute === 'is_active') {
                if ($originalValue == 0 && $currentValue == 1) {
                    $module->logActivities()->create([
                        'activity' => 'module status Deactivate to Activated',
                    ]);
                } elseif ($originalValue == 1 && $currentValue == 0) {
                    $module->logActivities()->create([
                        'activity' => 'module status Activate to Deactivated',
                    ]);
                }
            }
        }
    }
    /**
     * Handle the Module "deleted" event.
     */
    public function deleted(Module $module): void
    {
        // You can add code here to handle the "deleted" event.
    }

    /**
     * Handle the Module "restored" event.
     */
    public function restored(Module $module): void
    {
        // You can add code here to handle the "restored" event.
    }

    /**
     * Handle the Module "force deleted" event.
     */
    public function forceDeleted(Module $module): void
    {
        // You can add code here to handle the "force deleted" event.
    }
}
