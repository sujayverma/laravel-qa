<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use App\Http\Requests\AskQuestionRequest;
use App\Models\User;

class QuestionsController extends Controller
{

    public function __construct() {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
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
        // below with is used for solving N+1 query issue.
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
        //
        $this->authorize('update', $question);
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
        $this->authorize('update', $question);
        $question->update($request->only('title', 'body'));
        if($request->expectsJson())
        {
            return response()->json([
                'message' => 'Question updated successfully.',
                'body_html' => $question->bodyHtml
            ]);
        }

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
        $this->authorize('delete', $question);
        $question->delete();

        if(request()->expectsJson()){
            return response()->json([
                'message' => 'Question deleted successfully.'
            ]);
        }
        return redirect()->route('question.index')->with('success','Question deleted successfully.');
    }
}
