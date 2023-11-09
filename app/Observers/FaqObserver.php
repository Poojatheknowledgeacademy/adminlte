<?php

namespace App\Observers;

use App\Models\Faq;
use Illuminate\Support\Facades\Auth;

class FaqObserver
{
    /**
     * Handle the Faq "created" event.
     */
    public function created(Faq $faq): void
    {
        //$created_by = Auth::user()->id ?? NULL;
        $faq->logActivities()->create([
            'activity' => 'Faq created',
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
            if ($attribute == 'question' && $originalValue != $currentValue) {
                $faq->logActivities()->create([
                    'activity' =>"Question updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'answer' && $originalValue != $currentValue) {
                $faq->logActivities()->create([
                    'activity' =>  "Answer Updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'is_active' && $originalValue != $currentValue) {
                if ($originalValue == 0 && $currentValue == 1) {
                    $faq->logActivities()->create([
                        'activity' => 'Faq status Deactivate to Activated',
                    ]);
                } elseif ($originalValue == 1 && $currentValue == 0) {
                    $faq->logActivities()->create([
                        'activity' => 'Faq status Activate to Deactivated',
                    ]);
                }
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
