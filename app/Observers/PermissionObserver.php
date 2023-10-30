<?php

namespace App\Observers;

use App\Models\Permission;

class PermissionObserver
{
    /**
     * Handle the Permission "created" event.
     */
    public function created(Permission $permission): void
    {
        $permission->logActivities()->create([
            'activity' => "Permission created " . $permission->name,
        ]);
    }

    /**
     * Handle the Permission "updated" event.
     */
    public function updated(Permission $permission): void
    {
        $originalAttributes = $permission->getOriginal();

        foreach ($originalAttributes as $attribute => $originalValue) {
            $currentValue = $permission->$attribute;
            if ($attribute === 'updated_at' && $originalValue != $currentValue) {
                continue;
            }
            if ($attribute == 'name' && $originalValue != $currentValue) {
                $permission->logActivities()->create([
                    'activity' => "Permission Name updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'description' && $originalValue != $currentValue) {
                $permission->logActivities()->create([
                    'activity' => "Description updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'is_active' && $originalValue != $currentValue) {
                $permission->logActivities()->create([
                    'activity' =>  "Activity Updated",
                ]);
            }
        }
    }

    /**
     * Handle the Permission "deleted" event.
     */
    public function deleted(Permission $permission): void
    {
        //
    }

    /**
     * Handle the Permission "restored" event.
     */
    public function restored(Permission $permission): void
    {
        //
    }

    /**
     * Handle the Permission "force deleted" event.
     */
    public function forceDeleted(Permission $permission): void
    {
        //
    }
}
