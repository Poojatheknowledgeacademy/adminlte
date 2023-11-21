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
use App\Models\Course;

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

        Route::get('ActiveCategories', [CategoryController::class, 'getActiveCategories'])->name('getActiveCategories');
        Route::get('trashedCategory', [CategoryController::class, 'trashedCategory'])->name('trashedCategory');
        Route::get('restore/{category}', [CategoryController::class, 'restore'])->name('category.restore');
        Route::delete('delete/{category}', [CategoryController::class, 'delete'])->name('category.delete');

        Route::get('blog-country', [BlogController::class, 'storeblogcountry']);
        Route::get('ActiveCourse', [CourseController::class, 'getActiveCourse']);
        Route::get('coursesetpopular',      [CourseController::class, 'setPopular']);
});

Route::get('/country',             [CountryController::class, 'country']);
Route::get('users/activateaccount/{remember_token}', [UserController::class, 'activateaccount'])->name('activateaccount');
Route::post('/postactivate/{remember_token}', [UserController::class, 'postactivate'])->name('postactive');

// Route::group(['prefix' => '{country}', 'middleware' => 'country'], function () {
//     Route::get('/country_change',             [CountryController::class, 'countrychange']);
// });
