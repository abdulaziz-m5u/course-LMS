<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(){

        $courses =  Course::where('published', 1)->latest()->get();
        $purchased_courses = [];
        if (auth()->check()) {
            $purchased_courses = Course::whereHas('students', function($query) {
                $query->where('users.id', auth()->id());
            })
            ->with('lessons')
            ->orderBy('id', 'desc')
            ->get();
        }

        return view('courses', compact('courses','purchased_courses'));
    }

    public function show($course_slug)
    {
        $course = Course::where('slug', $course_slug)->with('publishedLessons')->firstOrFail();
        $purchased_course = auth()->check() && $course->students()->where('user_id', auth()->id())->count() > 0;
       
        return view('course', compact('course', 'purchased_course'));
    }

    public function payment(Request $request)
    {
        $course = Course::findOrFail($request->get('course_id'));

        $course->students()->attach(auth()->id());

        return redirect()->route('lessons.show', [$course->id, $request->lesson_id]);
    }

    public function rating($course_id, Request $request)
    {
        $course = Course::findOrFail($course_id);
        $course->students()->updateExistingPivot(auth()->id(), ['rating' => $request->get('rating')]);

        return redirect()->back()->with('success', 'Thank you for rating.');
    }
}
