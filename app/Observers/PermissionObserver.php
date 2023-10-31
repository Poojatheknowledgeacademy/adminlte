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
                    'activity' => "Permission Module Name updated.",
                ]);
            }
            if ($attribute == 'description' && $originalValue != $currentValue) {
                $permission->logActivities()->create([
                    'activity' => "Description updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute === 'is_active') {
                if ($originalValue == 0 && $currentValue == 1) {
                    $permission->logActivities()->create([
                        'activity' => 'Permission status Deactivate to Activated',
                    ]);
                } elseif ($originalValue == 1 && $currentValue == 0) {
                    $permission->logActivities()->create([
                        'activity' => 'Permission status Activate to Deactivated',
                    ]);
                }
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
