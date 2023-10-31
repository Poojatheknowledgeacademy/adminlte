<?php

namespace App\Observers;

use App\Models\BlogDetail;
use App\Models\Blog;

class BlogdetailObserver
{
    /**
     * Handle the BlogDetail "created" event.
     */
    public function created(BlogDetail $blogDetail): void
    {
        $blogDetail->logActivities()->create([
            'activity' => $blogDetail->meta_title.' created'
        ]);
    }

    /**
     * Handle the BlogDetail "updated" event.
     */
    public function updated(BlogDetail $blogDetail): void
    {
        $originalAttributes = $blogDetail->getOriginal();

        foreach ($originalAttributes as $attribute => $originalValue) {
            $currentValue = $blogDetail->$attribute;

            if ($attribute === 'updated_at' && $originalValue != $currentValue) {
                continue;
            }
            if ($attribute == 'blog_id' && $originalValue != $currentValue) {

                $oldcategoryname= Blog::find($originalValue)->title;
                $newcategoryname = Blog::find($currentValue)->title;
                $blogDetail->logActivities()->create([
                    'activity' =>"Blogdetails blogName updated from {$oldcategoryname} to {$newcategoryname}",
                ]);
            }
            if ($attribute == 'meta_title' && $originalValue != $currentValue) {
                $blogDetail->logActivities()->create([
                    'activity' =>"Blogdetails meta title  updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'meta_keywords' && $originalValue != $currentValue) {
                $blogDetail->logActivities()->create([
                    'activity' =>"Blogdetails meta keywords updated from {$originalValue} to {$currentValue}",
                ]);
            }

            if ($attribute == 'meta_description' && $originalValue != $currentValue) {
                $blogDetail->logActivities()->create([
                    'activity' =>"Blogdetails meta description updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'summary' && $originalValue != $currentValue) {
                $blogDetail->logActivities()->create([
                    'activity' =>"Blogdetails summary updated from {$originalValue} to {$currentValue}",
                ]);
            }

            if ($attribute === 'is_active') {
                if ($originalValue == 0 && $currentValue == 1) {
                    $blogDetail->logActivities()->create([
                        'activity' => 'Blogdetails status Deactivate to Activated',
                    ]);
                } elseif ($originalValue == 1 && $currentValue == 0) {
                    $blogDetail->logActivities()->create([
                        'activity' => 'Blogdetails status Activate to Deactivated',
                    ]);
                }
            }


        }
    }

    /**
     * Handle the BlogDetail "deleted" event.
     */
    public function deleted(BlogDetail $blogDetail): void
    {
        //
    }

    /**
     * Handle the BlogDetail "restored" event.
     */
    public function restored(BlogDetail $blogDetail): void
    {
        //
    }

    /**
     * Handle the BlogDetail "force deleted" event.
     */
    public function forceDeleted(BlogDetail $blogDetail): void
    {
        //
    }
}
