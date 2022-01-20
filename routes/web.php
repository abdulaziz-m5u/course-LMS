<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::group(['middleware' => ['isAdmin'],'prefix' => 'admin', 'as' => 'admin.'], function(){
    Route::resource('courses', \App\Http\Controllers\Admin\CourseController::class);
    Route::delete('courses_perma_del/{id}', [\App\Http\Controllers\Admin\CourseController::class, 'perma_del'])->name('courses.perma_del');
    Route::post('courses_restore/{id}', [\App\Http\Controllers\Admin\CourseController::class, 'restore'])->name('courses.restore');
    Route::resource('lessons', \App\Http\Controllers\Admin\LessonController::class);
    Route::post('lessons_restore/{id}', [\App\Http\Controllers\Admin\LessonController::class,'restore'])->name('lessons.restore');
    Route::delete('lessons_perma_del/{id}', [\App\Http\Controllers\Admin\LessonController::class,'perma_del'])->name('lessons.perma_del');

    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
});

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('courses/{slug}', [App\Http\Controllers\CourseController::class, 'show'])->name('courses.show');
Route::get('lessons/{course_id}/{slug}', [App\Http\Controllers\LessonController::class, 'show'])->name('lessons.show');
