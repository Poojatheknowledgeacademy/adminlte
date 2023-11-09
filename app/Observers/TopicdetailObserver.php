<?php

namespace App\Observers;

use App\Models\Country;
use App\Models\Topicdetail;
use Illuminate\Support\Facades\Auth;

class TopicdetailObserver
{
    /**
     * Handle the Topicdetail "created" event.
     */
    public function created(Topicdetail $topicdetail): void
    {
        $topicdetail->logActivities()->create([
            'activity' => "Topic Detail created " . $topicdetail->name,
        ]);
    }

    /**
     * Handle the Topicdetail "updated" event.
     */
    public function updated(Topicdetail $topicdetail): void
    {
        $originalAttributes = $topicdetail->getOriginal();

        foreach ($originalAttributes as $attribute => $originalValue) {
            $currentValue = $topicdetail->$attribute;
            if ($attribute === 'updated_at' && $originalValue != $currentValue) {
                continue;
            }
            if ($attribute == 'topic_id' && $originalValue != $currentValue) {
                $topicdetail->logActivities()->create([
                    'activity' => "Topicdetail TopicName updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'country_id' && $originalValue != $currentValue) {
                $originalCountryName = Country::find($originalValue)->name;
                $currentCountryName = Country::find($currentValue)->name;
                $topicdetail->logActivities()->create([
                    'activity' => "Topicdetail Country updated from {$originalCountryName} to {$currentCountryName}",
                ]);
            }
            if ($attribute == 'heading' && $originalValue != $currentValue) {
                $topicdetail->logActivities()->create([
                    'activity' => "Topicdetail Heading Updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'summary' && $originalValue != $currentValue) {
                $topicdetail->logActivities()->create([
                    'activity' => "Topicdetail summary Updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'detail' && $originalValue != $currentValue) {
                $topicdetail->logActivities()->create([
                    'activity' => "Topicdetail detail Updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'overview' && $originalValue != $currentValue) {
                $topicdetail->logActivities()->create([
                    'activity' => "Topicdetail overview Updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'whats_included' && $originalValue != $currentValue) {
                $topicdetail->logActivities()->create([
                    'activity' => "Topicdetail whats_included Updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'pre_requisite' && $originalValue != $currentValue) {
                $topicdetail->logActivities()->create([
                    'activity' => "Topicdetail pre_requisite Updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'who_should_attend' && $originalValue != $currentValue) {
                $topicdetail->logActivities()->create([
                    'activity' => "Topicdetail who_should_attend Updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'meta_title' && $originalValue != $currentValue) {
                $topicdetail->logActivities()->create([
                    'activity' => "Topicdetail meta_title Updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'meta_keywords' && $originalValue != $currentValue) {
                $topicdetail->logActivities()->create([
                    'activity' => "Topicdetail meta_keywords Updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'meta_description' && $originalValue != $currentValue) {
                $topicdetail->logActivities()->create([
                    'activity' => "Topicdetail meta_description Updated from {$originalValue} to {$currentValue}",
                ]);
            }
        }
    }

    /**
     * Handle the Topicdetail "deleted" event.
     */
    public function deleted(Topicdetail $topicdetail): void
    {
        //
    }

    /**
     * Handle the Topicdetail "restored" event.
     */
    public function restored(Topicdetail $topicdetail): void
    {
        //
    }

    /**
     * Handle the Topicdetail "force deleted" event.
     */
    public function forceDeleted(Topicdetail $topicdetail): void
    {
        //
    }
}
