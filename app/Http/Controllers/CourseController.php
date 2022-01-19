<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function show($course_slug){
        $course = Course::where('slug', $course_slug)->firstOrFail();
        return view('course', compact('course'));
    }
}
