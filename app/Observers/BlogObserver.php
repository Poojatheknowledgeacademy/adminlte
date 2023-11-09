<?php

namespace App\Observers;

use App\Models\Blog;
use App\Models\Country;
use App\Models\Category;
use App\Models\Tag;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Auth;

class BlogObserver
{
    /**
     * Handle the Course "created" event.
     */
    public function created(Blog $blog): void
    {
        $blog->logActivities()->create([
            'activity' => 'Blog'.$blog->title . ' created',
        ]);
    }
    /**
     * Handle the Blog "updated" event.
     */
    public function updated(Blog $blog): void
    {

        $originalAttributes = $blog->getOriginal();
        foreach ($originalAttributes as $attribute => $originalValue) {
            $currentValue = $blog->$attribute;
            if ($attribute === 'updated_at' && $originalValue != $currentValue) {
                continue;
            }
            if ($attribute == 'category_id' && $originalValue != $currentValue) {

                $oldcategoryname = Category::find($originalValue)->name;
                $newcategoryname = Category::find($currentValue)->name;
                $blog->logActivities()->create([
                    'activity' => "Blog Category Name updated from {$oldcategoryname} to {$newcategoryname}",
                ]);
            }
            if ($attribute == 'short_description' && $originalValue != $currentValue) {
                $blog->logActivities()->create([
                    'activity' => "Blog short description  updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'title' && $originalValue != $currentValue) {
                $blog->logActivities()->create([
                    'activity' => "Blog Title updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'featured_img1' && $originalValue != $currentValue) {
                $blog->logActivities()->create([
                    'activity' => "Blog Featured image 1 updated",
                ]);
            }
            if ($attribute == 'featured_img2' && $originalValue != $currentValue) {
                $blog->logActivities()->create([
                    'activity' => "Blog Featured image 2 updated",
                ]);
            }
            if ($attribute == 'author_name' && $originalValue != $currentValue) {
                $blog->logActivities()->create([
                    'activity' => "Blog Author Name updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'added_date' && $originalValue != $currentValue) {
                $blog->logActivities()->create([
                    'activity' => "Blog Date updated from {$originalValue} to {$currentValue}",
                ]);
            }
            if ($attribute == 'country_id' && $originalValue != $currentValue) {

                $oldcountryname = Country::find($originalValue)->name;
                $newcountryname = Country::find($currentValue)->name;
                $blog->logActivities()->create([
                    'activity' => "Blog Category Name updated from {$oldcountryname} to {$newcountryname}",
                ]);
            }
            if ($attribute === 'is_active') {
                if ($originalValue == 0 && $currentValue == 1) {
                    $blog->logActivities()->create([
                        'activity' => 'Blog status Deactivate to Activated',
                    ]);
                } elseif ($originalValue == 1 && $currentValue == 0) {
                    $blog->logActivities()->create([
                        'activity' => 'Blog status Activate to Deactivated',
                    ]);
                }
            }
            if ($attribute === 'is_popular') {
                if ($originalValue == 0 && $currentValue == 1) {
                    $blog->logActivities()->create([
                        'activity' => 'Blog popular off to on',
                    ]);
                } elseif ($originalValue == 1 && $currentValue == 0) {
                    $blog->logActivities()->create([
                        'activity' => 'Blog popular on to off',
                    ]);
                }
            }
        }
    }
    /**
     * Handle the Course "deleted" event.
     */
    public function deleted(Blog $course): void
    {
        //
    }

    /**
     * Handle the Course "restored" event.
     */
    public function restored(Blog $course): void
    {
        //
    }

    /**
     * Handle the Course "force deleted" event.
     */
    public function forceDeleted(Blog $course): void
    {
        //
    }
}
