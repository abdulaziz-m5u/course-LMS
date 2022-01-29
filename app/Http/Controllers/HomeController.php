<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $purchased_courses = [];
        if (auth()->check()) {
            $purchased_courses = Course::whereHas('students', function($query) {
                $query->where('users.id', auth()->id());
            })
            ->with('lessons')
            ->orderBy('id', 'desc')
            ->get();
        }

        $courses =  Course::where('published', 1)->latest()->get();

        return view('index', compact('courses','purchased_courses'));
    }
}
