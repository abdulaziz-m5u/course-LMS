<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
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

        return redirect()->back()->with('success', 'Payment completed successfully.');
    }

    public function rating($course_id, Request $request)
    {
        $course = Course::findOrFail($course_id);
        $course->students()->updateExistingPivot(auth()->id(), ['rating' => $request->get('rating')]);

        return redirect()->back()->with('success', 'Thank you for rating.');
    }
}
