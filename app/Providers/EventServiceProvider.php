<?php

namespace App\Providers;

use App\Models\Faq;
use App\Models\Tag;
use App\Models\Blog;
use App\Models\Role;
<<<<<<< HEAD
use App\Models\User;
=======
>>>>>>> c59aee85bcf1cac89aaea267e8e06f8ddddaaef8
use App\Models\Topic;
use App\Models\Course;
use App\Models\Module;
use App\Models\Category;
<<<<<<< HEAD
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
=======
use App\Models\Coursedetail;
use App\Observers\FaqObserver;
use App\Observers\TagObserver;
use App\Observers\BlogObserver;
use App\Observers\RoleObserver;
use App\Observers\TopicObserver;
use App\Observers\CourseObserver;
use App\Observers\CategoryObserver;
use App\Observers\ModuleObserver;
>>>>>>> c59aee85bcf1cac89aaea267e8e06f8ddddaaef8
use Illuminate\Auth\Events\Registered;
use App\Observers\CoursedetailObserver;
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
<<<<<<< HEAD
        User::observe(UserObserver::class);
        Topicdetail::observe(TopicdetailObserver::class);
        Permission::observe(PermissionObserver::class);
       
=======
        Tag::observe(TagObserver::class);
        Coursedetail::observe(CoursedetailObserver::class);
        Faq::observe(FaqObserver::class);
        Role::observe(RoleObserver::class);
        Module::observe(ModuleObserver::class);
>>>>>>> c59aee85bcf1cac89aaea267e8e06f8ddddaaef8
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
