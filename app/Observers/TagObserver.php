<?php

namespace App\Observers;

use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class TagObserver
{
    /**
     * Handle the Tag "created" event.
     */
    public function created(Tag $tag): void
    {

        $tag->logActivities()->create([
            'activity' => 'Tag '.$tag->name.' created',
        ]);
    }

    /**
     * Handle the Tag "updated" event.
     */
    public function updated(Tag $tag): void
    {
        $originalAttributes = $tag->getOriginal();

        foreach ($originalAttributes as $attribute => $originalValue) {
            $currentValue = $tag->$attribute;
            if ($attribute === 'updated_at' && $originalValue != $currentValue) {
                continue;
            }
            if ($attribute == 'name' && $originalValue != $currentValue) {
                $tag->logActivities()->create([
                    'activity' =>"Tag Name updated from {$originalValue} to {$currentValue}",
                ]);
            }


            if ($attribute == 'is_active' && $originalValue != $currentValue) {
                if ($originalValue == 0 && $currentValue == 1) {
                    $tag->logActivities()->create([
                        'activity' => 'Tag status Deactivate to Activated',
                    ]);
                } elseif ($originalValue == 1 && $currentValue == 0) {
                    $tag->logActivities()->create([
                        'activity' => 'Tag status Activate to Deactivated',
                    ]);
                }
            }
        }
    }

    /**
     * Handle the Tag "deleted" event.
     */
    public function deleted(Tag $tag): void
    {
        //
    }

    /**
     * Handle the Tag "restored" event.
     */
    public function restored(Tag $tag): void
    {
        //
    }

    /**
     * Handle the Tag "force deleted" event.
     */
    public function forceDeleted(Tag $tag): void
    {
        //
    }
}
