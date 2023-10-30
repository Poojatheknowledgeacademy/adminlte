<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\Role;
use App\Models\User;
use App\Models\Topic;
use App\Models\Course;
use App\Models\Category;
use App\Models\Permission;
use App\Models\Topicdetail;
use App\Observers\BlogObserver;
use App\Observers\RoleObserver;
use App\Observers\UserObserver;
use App\Observers\TopicObserver;
use App\Observers\CourseObserver;
use App\Observers\CategoryObserver;
use App\Observers\PermissionObserver;
use App\Observers\TopicdetailObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Topic::observe(TopicObserver::class);
        Course::observe(CourseObserver::class);
        Blog::observe(BlogObserver::class);
        Category::observe(CategoryObserver::class);
        User::observe(UserObserver::class);
        Topicdetail::observe(TopicdetailObserver::class);
        Permission::observe(PermissionObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
