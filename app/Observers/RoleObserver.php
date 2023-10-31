<?php

namespace App\Observers;
use Spatie\Permission\Models\Role;
class RoleObserver
{
    /**
     * Handle the Role "created" event.
     */
    public function created(Role $role): void
    {
        $role->logActivities()->create([
            'activity' => 'Role ' . $role->name . ' created'
        ]);
    }
    /**
     * Handle the Role "updated" event.
     */
    public function updated(Role $role): void
    {
        $originalAttributes = $role->getOriginal();

        foreach ($originalAttributes as $attribute => $originalValue) {
            $currentValue = $role->$attribute;
            if ($attribute === 'updated_at' && $originalValue != $currentValue) {
                continue;
            }
            if ($attribute == 'name' && $originalValue != $currentValue) {
                $role->logActivities()->create([
                    'activity' => "Role Name updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'description' && $originalValue != $currentValue) {
                $role->logActivities()->create([
                    'activity' =>  "Role Description Updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'is_active' && $originalValue != $currentValue) {
                $role->logActivities()->create([
                    'activity' =>  "Role Activity Updated",
                ]);
            }
        }
    }

    /**
     * Handle the Role "deleted" event.
     */
    public function deleted(Role $role): void
    {
        //
    }

    /**
     * Handle the Role "restored" event.
     */
    public function restored(Role $role): void
    {
        //
    }

    /**
     * Handle the Role "force deleted" event.
     */
    public function forceDeleted(Role $role): void
    {
        //
    }
}
