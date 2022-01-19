<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCoursesRequest;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('course_access')) {
            return abort(401);
        }

        if (request('show_deleted') == 1) {
            if (! Gate::allows('course_delete')) {
                return abort(401);
            }
            $courses = Course::onlyTrashed()->ofTeacher()->get();
        } else {
            $courses = Course::ofTeacher()->get();
        }    

        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('course_create')) {
            return abort(401);
        }

        $teachers = User::whereHas('role', function ($q) { 
                $q->where('role_id', 2); 
            })
            ->get()
            ->pluck('name', 'id');

        return view('admin.courses.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCoursesRequest $request)
    {
        $data = $request->all();
        $data['course_image'] = $request->file('course_image')->store(
            'images/courses', 'public'
        );
        $course = Course::create($data);
        $teachers = auth()->user()->isAdmin() ? array_filter((array)$request->input('teachers')) : [auth()->id()];
        $course->teachers()->sync($teachers);

        return redirect()->route('admin.courses.index');
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
    public function edit(Course $course)
    {
        $teachers = User::whereHas('role', function ($q) { 
            $q->where('role_id', 2); 
        })
        ->get()
        ->pluck('name', 'id');

        return view('admin.courses.edit', compact('course', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCoursesRequest $request, Course $course)
    {
        $data = $request->all();
        if($request->has('course_image')){
            Storage::disk('public')->delete($course->course_image);

            $data['course_image'] = $request->file('course_image')->store(
                'images/courses', 'public'
            );
        }       
        
        $course->update($data);
        $teachers = auth()->user()->isAdmin() ? array_filter((array)$request->input('teachers')) : [auth()->id()];
        $course->teachers()->sync($teachers);

        return redirect()->route('admin.courses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        if (! Gate::allows('course_delete')) {
            return abort(401);
        }

        $course->delete();

        return redirect()->route('admin.courses.index');
    }

     /**
     * Restore Course from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('course_delete')) {
            return abort(401);
        }

        $course = Course::onlyTrashed()->findOrFail($id);
        $course->restore();

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

        $course = Course::onlyTrashed()->findOrFail($id);
        $course->forceDelete();

        return redirect()->route('admin.courses.index');
    }
}
