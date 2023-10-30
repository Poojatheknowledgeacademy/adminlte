<?php

namespace App\Observers;

use App\Models\Role;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $user->logActivities()->create([
            'activity' => "User created " . $user->name,
        ]);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $originalAttributes = $user->getOriginal();

        foreach ($originalAttributes as $attribute => $originalValue) {
            $currentValue = $user->$attribute;
            if ($attribute === 'updated_at' && $originalValue != $currentValue) {
                continue;
            }
            if ($attribute == 'name' && $originalValue != $currentValue) {
                $user->logActivities()->create([
                    'activity' => "User Name updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'email' && $originalValue != $currentValue) {
                $user->logActivities()->create([
                    'activity' => "Email updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'user_id' && $originalValue != $currentValue) {
                $oldRoleName = Role::find($originalValue)->name;
                $newRoleName = Role::find($currentValue)->name;
                $user->logActivities()->create([
                    'activity' => "user updated from {$oldRoleName} to {$newRoleName}",
                ]);
            }
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
