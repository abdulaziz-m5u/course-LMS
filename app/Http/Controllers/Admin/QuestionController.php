<?php

namespace App\Http\Controllers\Admin;

use App\Models\Test;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\QuestionOption;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('question_access')) {
            return abort(401);
        }

        if (request('show_deleted') == 1) {
            if (! Gate::allows('question_delete')) {
                return abort(401);
            }
            $questions = Question::onlyTrashed()->get();
        } else {
            $questions = Question::all();
        }

        return view('admin.questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('question_create')) {
            return abort(401);
        }
        $tests = Test::get()->pluck('title', 'id');

        return view('admin.questions.create', compact('tests'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('question_create')) {
            return abort(401);
        }

        $data = $request->only('question','question_image','score');
        if($request->hasFile('question_image')){
            $data['question_image'] = $request->file('question_image')->store(
                'images/questions', 'public'
            );
        }
        $question = Question::create($data);
        $question->tests()->sync(array_filter((array)$request->input('test')));

        for ($q=1; $q <= 4; $q++) {
            $option = $request->input('option_text_' . $q, '');
            if ($option != '') {
                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => $option,
                    'correct' => $request->input('correct_' . $q) ? 1 : 0,
                ]);
            }
        }

        return redirect()->route('admin.questions.index');
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
    public function edit(Question $question)
    {
        if (! Gate::allows('question_edit')) {
            return abort(401);
        }
        $tests = Test::get()->pluck('title', 'id');

        return view('admin.questions.edit', compact('question', 'tests'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Question $question)
    {
        if (! Gate::allows('question_edit')) {
            return abort(401);
        }

        $data = $request->only('question','question_image','score');
        if($request->hasFile('question_image')){
            Storage::disk('public')->delete($question->question_image);
            $data['question_image'] = $request->file('question_image')->store(
                'images/questions', 'public'
            );
        }
        $question->update($data);
        $question->tests()->sync(array_filter((array)$request->input('tests')));



        return redirect()->route('admin.questions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        if (! Gate::allows('question_delete')) {
            return abort(401);
        }
        $question->delete();

        return redirect()->route('admin.questions.index');
    }

     /**
     * Restore Question from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('question_delete')) {
            return abort(401);
        }
        $question = Question::onlyTrashed()->findOrFail($id);
        $question->restore();

        return redirect()->route('admin.questions.index');
    }

      /**
     * Permanently delete Question from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('question_delete')) {
            return abort(401);
        }
        $question = Question::onlyTrashed()->findOrFail($id);
        $question->forceDelete();

        return redirect()->route('admin.questions.index');
    }
}
