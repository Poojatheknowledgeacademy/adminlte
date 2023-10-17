<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TopicFaqController;

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

    Route::get('dashboard',         [HomeController::class, 'index'])->name('home.index');
    Route::resource('users',        UserController::class);
    Route::resource('category',     CategoryController::class);
    Route::resource('blogs',        BlogController::class);
    Route::resource('topic',        TopicController::class);
    Route::resource('course',       CourseController::class);
    Route::resource('tag',          TagController::class);
    Route::resource('permission',   PermissionController::class);
    Route::resource('roles',        RoleController::class);
    Route::resource('topic.faqs',   TopicFaqController::class);
});
