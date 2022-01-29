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
  
    Route::resource('tests', \App\Http\Controllers\Admin\TestController::class);
    Route::post('tests_restore/{id}', [\App\Http\Controllers\Admin\TestController::class,'restore'])->name('tests.restore');
    Route::delete('tests_perma_del/{id}', [\App\Http\Controllers\Admin\TestController::class,'perma_del'])->name('tests.perma_del');
  
    Route::resource('questions', \App\Http\Controllers\Admin\QuestionController::class);
    Route::post('questions_restore/{id}', [\App\Http\Controllers\Admin\QuestionController::class,'restore'])->name('questions.restore');
    Route::delete('questions_perma_del/{id}', [\App\Http\Controllers\Admin\QuestionController::class,'perma_del'])->name('questions.perma_del');
   
    Route::resource('question_options', \App\Http\Controllers\Admin\QuestionOptionController::class);
    Route::post('question_options_restore/{id}', [\App\Http\Controllers\Admin\QuestionOptionController::class, 'restore'])->name('question_options.restore');
    Route::delete('question_options_perma_del/{id}', [\App\Http\Controllers\Admin\QuestionOptionController::class, 'perma_del'])->name('question_options.perma_del');

    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
});

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('courses', [App\Http\Controllers\CourseController::class, 'index'])->name('courses.index');
Route::get('courses/{slug}', [App\Http\Controllers\CourseController::class, 'show'])->name('courses.show');
Route::post('courses/payment', [App\Http\Controllers\CourseController::class, 'payment'])->name('courses.payment');
Route::post('course/{course_id}/rating', [App\Http\Controllers\CourseController::class, 'rating'])->name('courses.rating');

Route::get('lessons/{course_id}/{slug}', [App\Http\Controllers\LessonController::class, 'show'])->name('lessons.show');
Route::post('lesson/{slug}/test', [App\Http\Controllers\LessonController::class, 'test'])->name('lessons.test');
