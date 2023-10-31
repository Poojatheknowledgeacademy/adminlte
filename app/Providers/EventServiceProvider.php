<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\Role;
use App\Models\User;
use App\Models\Topic;
use App\Models\Course;
use App\Models\Category;
use App\Models\BlogDetail;
use App\Models\Permission;
use App\Models\Topicdetail;
use App\Models\Coursedetail;
use App\Models\Tag;
use App\Models\Faq;

use App\Observers\BlogObserver;
use App\Observers\RoleObserver;
use App\Observers\UserObserver;
use App\Observers\TopicObserver;
use App\Observers\CourseObserver;
use App\Observers\CategoryObserver;
use App\Observers\BlogdetailObserver;
use App\Observers\PermissionObserver;
use App\Observers\TopicdetailObserver;
use App\Observers\TagObserver;
use App\Observers\CoursedetailObserver;
use App\Observers\FaqObserver;

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
        BlogDetail::observe(BlogdetailObserver::class);
        Tag::observe(TagObserver::class);
        Coursedetail::observe(CoursedetailObserver::class);
        Faq::observe(FaqObserver::class);
        Role::observe(RoleObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
