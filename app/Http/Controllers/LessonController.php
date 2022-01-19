<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function show($course_id, $lesson_slug)
    {
        $lesson = Lesson::where('slug', $lesson_slug)->where('course_id', $course_id)->firstOrFail();

        $previous_lesson = Lesson::where('course_id', $lesson->course_id)
            ->where('position', '<', $lesson->position)
            ->orderBy('position', 'desc')
            ->first();
        $next_lesson = Lesson::where('course_id', $lesson->course_id)
            ->where('position', '>', $lesson->position)
            ->orderBy('position', 'asc')
            ->first();

        return view('lesson', compact('lesson', 'previous_lesson', 'next_lesson'));
    }
}
