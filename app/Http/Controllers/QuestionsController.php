<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use App\Http\Requests\AskQuestionRequest;
use App\Models\User;
// use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\Gate;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // DB::enableQueryLog();
        // $questions = Question::latest()->paginate(5);
        $questions = Question::with('user')->latest()->paginate(5);
        return view('questions.index', compact('questions'));
        // view('questions.index', compact('questions'))->render();
        // dd(DB::getQueryLog());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $question = new Question(); // empty question model.
        return view('questions.create', compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
        $request->user()->questions()->create($request->only('title', 'body'));
        return redirect()->route('question.index')->with('success', 'Your Question has been Submitted');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question->increment('views');
        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        
        if( ! Gate::allows('update-question', $question) ){
            abort(403, 'Fuck off!!');
        }
        // if (Gate::forUser(User)->denies('update-post', $question)) {
        //     // The user can't update the post...
        // }
        return view('questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        //
        $question->update($request->only('title', 'body'));
        return redirect()->route('question.index')->with('success','Question updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
        if( ! Gate::allows('delete-question', $question) ){
            abort(403, 'Access Denied');
        }
        $question->delete();
        return redirect()->route('question.index')->with('success','Question deleted successfully.');
    }
}
