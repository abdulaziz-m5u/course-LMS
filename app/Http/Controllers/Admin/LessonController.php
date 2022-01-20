<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (! Gate::allows('lesson_access')) {
            return abort(401);
        }

        $lessons = Lesson::whereIn('course_id', Course::ofTeacher()->pluck('id'));

        if ($request->input('course_id')) {
            $lessons = $lessons->where('course_id', $request->input('course_id'));
        }
        if (request('show_deleted') == 1) {
            if (! Gate::allows('lesson_delete')) {
                return abort(401);
            }
            $lessons = $lessons->onlyTrashed()->get();
        } else {
            $lessons = $lessons->get();
        }

        return view('admin.lessons.index', compact('lessons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('lesson_create')) {
            return abort(401);
        }
        $courses = Course::ofTeacher()
            ->get()
            ->pluck('title', 'id')
            ->prepend('Please select', '');

        return view('admin.lessons.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('lesson_create')) {
            return abort(401);
        }
        Lesson::create(
            $request->all() + ['position' => Lesson::where('course_id', $request->course_id)->max('position') + 1]
        );

        return redirect()->route('admin.lessons.index',  ['course_id' => $request->course_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        if (! Gate::allows('lesson_edit')) {
            return abort(401);
        }
        $courses = Course::ofTeacher()->get()->pluck('title', 'id')->prepend('Please select', '');

        return view('admin.lessons.edit', compact('lesson', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Lesson $lesson)
    {
        if (! Gate::allows('lesson_edit')) {
            return abort(401);
        }
        $lesson->update($request->all());

        return redirect()->route('admin.lessons.index',  ['course_id' => $request->course_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        if (! Gate::allows('lesson_delete')) {
            return abort(401);
        }
        $lesson->delete();

        return redirect()->route('admin.lessons.index');
    }

    public function restore($id)
    {
        if (! Gate::allows('course_delete')) {
            return abort(401);
        }
        $lesson = Lesson::onlyTrashed()->findOrFail($id);
        $lesson->restore();

        return redirect()->route('admin.courses.index');
    }

     /**
     * Permanently delete Course from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('course_delete')) {
            return abort(401);
        }
        $lesson = Lesson::onlyTrashed()->findOrFail($id);
        $lesson->forceDelete();

        return redirect()->route('admin.courses.index');
    }
}
