<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Question;
use App\Models\TestResult;
use Illuminate\Http\Request;
use App\Models\QuestionOption;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function show($course_id, $lesson_slug)
    {

        $lesson = Lesson::with('test')->where('slug', $lesson_slug)->where('course_id', $course_id)->firstOrFail();
       
        if (auth()->check())
        {
            if ($lesson->students()->where('user_id', auth()->id())->count() == 0) {
                $lesson->students()->attach(auth()->id());
            }
        }

        $test_result = NULL;
        if ($lesson->test) {
            $test_result = TestResult::where('test_id', $lesson->test->id)
                ->where('user_id', auth()->id())
                ->first();
        }

        $previous_lesson = Lesson::where('course_id', $lesson->course_id)
            ->where('position', '<', $lesson->position)
            ->orderBy('position', 'desc')
            ->first();
        $next_lesson = Lesson::where('course_id', $lesson->course_id)
            ->where('position', '>', $lesson->position)
            ->orderBy('position', 'asc')
            ->first();

        $purchased_course = $lesson->course->students()->where('user_id', auth()->id())->count() > 0;
        $test_exists = FALSE;
        if ($lesson->test && $lesson->test->questions->count() > 0) {
            $test_exists = TRUE;
        }

        return view('lesson', compact('lesson', 'previous_lesson', 'next_lesson','purchased_course','test_exists','test_result'));
    }

    public function test($lesson_slug, Request $request)
    {
        $lesson = Lesson::where('slug', $lesson_slug)->firstOrFail();
        $answers = [];
        $test_score = 0;
        foreach ($request->get('questions') as $question_id => $answer_id) {
            $question = Question::find($question_id);
            $correct = QuestionOption::where('question_id', $question_id)
                ->where('id', $answer_id)
                ->where('correct', 1)->count() > 0;
            $answers[] = [
                'question_id' => $question_id,
                'question_option_id' => $answer_id,
                'correct' => $correct
            ];
            if ($correct) {
                $test_score += $question->score;
            }
            /*
             * Save the answer
             * Check if it is correct and then add points
             * Save all test result and show the points
             */
        }
        $test_result = TestResult::create([
            'test_id' => $lesson->test->id,
            'user_id' => auth()->id(),
            'test_result' => $test_score
        ]);
        $test_result->answers()->createMany($answers);

        return redirect()->route('lessons.show', [$lesson->course_id, $lesson_slug])->with('message', 'Test score: ' . $test_score);
    }
}
