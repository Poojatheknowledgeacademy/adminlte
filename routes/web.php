<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BlogDetailController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Failed_JobsController;
use App\Http\Controllers\TopicDetailController;
use App\Http\Controllers\UrlRedirectController;
use App\Http\Controllers\CoursedetailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',             [AuthController::class, 'index'])->name('login');
Route::get('/login',        [AuthController::class, 'index'])->name('login');
Route::post('custom-login', [AuthController::class, 'customLogin'])->name('login.custom');
Route::post('logout',       [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    // Route::group(['prefix' => '{country?}', 'where' => ['country' => '[a-z]{2}'], 'middleware' => 'country'], function () {
    Route::get('dashboard',             [HomeController::class, 'index'])->name('dashboard.index');

    //});
    // Route::get('aa/{name?}', function (?string $name = null) {
    //     return $name;
    // });


    Route::resource('users',         UserController::class);
    Route::resource('category',         CategoryController::class);
    Route::resource('blogs',            BlogController::class);
    Route::resource('topic',            TopicController::class);
    Route::resource('course',           CourseController::class);
    Route::resource('tag',              TagController::class);
    Route::resource('permission',       PermissionController::class);
    Route::resource('roles',            RoleController::class);
    Route::resource('url_redirect',     UrlRedirectController::class);
    Route::resource('module',           ModuleController::class);
    Route::resource('jobs',             JobsController::class);
    Route::resource('failed_jobs',      Failed_JobsController::class);


    Route::resource('topic.faqs',               FaqController::class);
    Route::resource('course.faqs',              FaqController::class);
    Route::resource('course.coursedetails',     CoursedetailController::class);
    Route::resource('topic.topicdetails',       TopicDetailController::class);
    Route::resource('blogs.blogDetail',         BlogDetailController::class);

    Route::get('changetopicStatus',       [TopicController::class, 'updateStatus']);
    Route::get('changecourseStatus',      [CourseController::class, 'courseStatus']);
    Route::get('changetagStatus',         [TagController::class, 'tagStatus']);
    Route::get('changeroleStatus',        [RoleController::class, 'roleStatus']);
    Route::get('changepermissionStatus',  [PermissionController::class, 'permissionStatus']);
    Route::get('changeblogStatus',        [BlogController::class, 'blogStatus']);
    Route::get('changecategoryStatus',    [CategoryController::class, 'categoryStatus']);
    Route::get('changefaqStatus',         [FaqController::class, 'faqStatus']);
    Route::get('changeModuleStatus',      [ModuleController::class, 'updateStatus']);
    Route::get('changeblogdetailsStatus', [BlogDetailController::class, 'updateStatus']);

    Route::get('ActiveCategories',        [CategoryController::class, 'getActiveCategories'])->name('getActiveCategories');

    Route::get('trashedCategory',               [CategoryController::class, 'trashedCategory'])->name('trashedCategory');
    Route::get('restore/{category}',            [CategoryController::class, 'restore'])->name('category.restore');
    Route::delete('delete/{category}',          [CategoryController::class, 'delete'])->name('category.delete');

    Route::get('trashedTopic',                  [TopicController::class, 'trashedTopic'])->name('trashedTopic');
    Route::get('topic/restore/{topic}',         [TopicController::class, 'restore'])->name('topic.restore');
    Route::delete('topic/delete/{topic}',       [TopicController::class, 'delete'])->name('topic.delete');

    Route::get('trashedCourse',                 [CourseController::class, 'trashedCourse'])->name('trashedCourse');
    Route::get('course/restore/{course}',       [CourseController::class, 'restore'])->name('course.restore');
    Route::delete('course/delete/{course}',     [CourseController::class, 'delete'])->name('course.delete');

    Route::get('trashedBlog',                   [BlogController::class, 'trashedBlog'])->name('trashedBlog');
    Route::get('blog/restore/{blog}',           [BlogController::class, 'restore'])->name('blog.restore');
    Route::delete('blog/delete/{blog}',         [BlogController::class, 'delete'])->name('blog.delete');

    Route::get('trashedRole',                   [RoleController::class, 'trashedRole'])->name('trashedRole');
    Route::get('restore/{role}',                [RoleController::class, 'restore'])->name('role.restore');
    Route::delete('delete/{role}',              [RoleController::class, 'delete'])->name('role.delete');

    Route::get('trashedTag',                    [TagController::class, 'trashedTag'])->name('trashedTag');
    Route::get('tag/restoreTag/{tag}',          [TagController::class, 'restoreTag'])->name('tag.restore');
    Route::delete('tag/deleteTag/{tag}',        [TagController::class, 'deleteTag'])->name('tag.delete');

    Route::get('trashedUser',                   [UserController::class, 'trashedUser'])->name('trashedUser');
    Route::get('user/restore/{user}',           [UserController::class, 'restore'])->name('user.restore');
    Route::delete('user/delete/{user}',         [UserController::class, 'delete'])->name('user.delete');

    Route::get('trashedPermission',                 [PermissionController::class, 'trashedPermission'])->name('trashedPermission');
    Route::get('permission/restore/{permission}',   [PermissionController::class, 'restore'])->name('permission.restore');
    Route::delete('permission/delete/{permission}', [PermissionController::class, 'delete'])->name('permission.delete');


    Route::get('trashedModule',                 [ModuleController::class, 'trashedModule'])->name('trashedModule');
    Route::get('module/restore/{module}',       [ModuleController::class, 'restore'])->name('module.restore');
    Route::delete('module/delete/{module}',     [ModuleController::class, 'delete'])->name('module.delete');


    Route::get('trashedCoursedetail',                   [CoursedetailController::class, 'trashedCoursedetail'])->name('trashedCoursedetail');
    Route::get('coursedetail/restore/{coursedetail}',   [CoursedetailController::class, 'restore'])->name('coursedetail.restore');
    Route::delete('coursedetail/delete/{coursedetail}', [CoursedetailController::class, 'delete'])->name('coursedetail.delete');

    Route::get('trashedTopicDetail',                    [TopicDetailController::class, 'trashedTopicDetail'])->name('trashedTopicDetail');
    Route::get('topicdetail/restore/{topicdetail}',     [TopicDetailController::class, 'restore'])->name('topicdetail.restore');
    Route::delete('topicdetail/delete/{topicdetail}',   [TopicDetailController::class, 'delete'])->name('topicdetail.delete');

    Route::get('trashedBlogDetail',                     [BlogDetailController::class, 'trashedBlogDetail'])->name('trashedBlogDetail');
    Route::get('blogdetail/restore/{blogdetail}',       [BlogDetailController::class, 'restore'])->name('blogdetail.restore');
    Route::delete('blogdetail/delete/{blogdetail}',     [BlogDetailController::class, 'delete'])->name('blogdetail.delete');

    Route::get('blog-country', [BlogController::class, 'storeblogcountry']);
    Route::get('blogsetpopular', [BlogController::class, 'setPopular']);

    Route::get('ActiveCourse', [CourseController::class, 'getActiveCourse']);
    Route::get('coursesetpopular',      [CourseController::class, 'setPopular']);


    Route::get('country-category', [CategoryController::class, 'storeCategoryCountry']);
    Route::get('categorysetpopular', [CategoryController::class, 'setPopular']);


    Route::get('country-topics',        [TopicController::class, 'storeTopicCountry']);
    Route::get('topicsetpopular',       [TopicController::class, 'setPopular']);
});

Route::get('/country',             [CountryController::class, 'country']);
Route::get('users/activateaccount/{remember_token}', [UserController::class, 'activateaccount'])->name('activateaccount');
Route::post('/postactivate/{remember_token}', [UserController::class, 'postactivate'])->name('postactive');

Route::group(['prefix' => '{country}', 'middleware' => 'country'], function () {
    Route::get('/country_change',             [CountryController::class, 'countrychange']);
});
