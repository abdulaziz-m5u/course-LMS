<?php

namespace App\Http\Controllers\Admin;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\QuestionOption;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class QuestionOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('questions_option_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('questions_option_delete')) {
                return abort(401);
            }
            $question_options = QuestionOption::onlyTrashed()->get();
        } else {
            $question_options = QuestionOption::all();
        }

        return view('admin.question_options.index', compact('question_options'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('questions_option_create')) {
            return abort(401);
        }
        $questions = Question::get()->pluck('question', 'id')->prepend('Please select', '');

        return view('admin.question_options.create', compact('questions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('questions_option_create')) {
            return abort(401);
        }
        QuestionOption::create($request->except('correct') + ['correct' => $request->input('correct') ? 1 : 0]);

        return redirect()->route('admin.question_options.index');
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
    public function edit(QuestionOption $question_option)
    {
        if (! Gate::allows('questions_option_edit')) {
            return abort(401);
        }
        $questions = Question::get()->pluck('question', 'id')->prepend('Please select', '');

        return view('admin.question_options.edit', compact('question_option', 'questions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,QuestionOption $question_option)
    {
        if (! Gate::allows('questions_option_edit')) {
            return abort(401);
        }
        $question_option->update($request->except('correct') + ['correct' => $request->input('correct') ? 1 : 0]);

        return redirect()->route('admin.question_options.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionOption $question_option)
    {
        if (! Gate::allows('questions_option_delete')) {
            return abort(401);
        }
        $question_option->delete();

        return redirect()->route('admin.question_options.index');
    }

     /**
     * Restore QuestionsOption from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('questions_option_delete')) {
            return abort(401);
        }
        $question_option = QuestionOption::onlyTrashed()->findOrFail($id);
        $question_option->restore();

        return redirect()->route('admin.question_options.index','?show_deleted=1');
    }

    /**
     * Permanently delete QuestionsOption from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('questions_option_delete')) {
            return abort(401);
        }
        $question_option = QuestionOption::onlyTrashed()->findOrFail($id);
        $question_option->forceDelete();

        return redirect()->route('admin.question_options.index','?show_deleted=1');
    }
}
