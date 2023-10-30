<?php

namespace App\Observers;

use App\Models\Faq;

class FaqObserver
{
    /**
     * Handle the Faq "created" event.
     */
    public function created(Faq $faq): void
    {
        $faq->logActivities()->create([
            'activity' => 'Faq created'
        ]);
    }

    /**
     * Handle the Faq "updated" event.
     */
    public function updated(Faq $faq): void
    {
        $originalAttributes = $faq->getOriginal();

        foreach ($originalAttributes as $attribute => $originalValue) {
            $currentValue = $faq->$attribute;
            if ($attribute === 'updated_at' && $originalValue != $currentValue) {
                continue;
            }
            if ($attribute == 'name' && $originalValue != $currentValue) {
                $faq->logActivities()->create([
                    'activity' =>"Role Name updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'description' && $originalValue != $currentValue) {
                $faq->logActivities()->create([
                    'activity' =>  "Role Description Updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'is_active' && $originalValue != $currentValue) {
                $faq->logActivities()->create([
                    'activity' =>  "Role Activity Updated",
                ]);
            }
        }
    }

    /**
     * Handle the Faq "deleted" event.
     */
    public function deleted(Faq $faq): void
    {
        //
    }

    /**
     * Handle the Faq "restored" event.
     */
    public function restored(Faq $faq): void
    {
        //
    }

    /**
     * Handle the Faq "force deleted" event.
     */
    public function forceDeleted(Faq $faq): void
    {
        //
    }
}
