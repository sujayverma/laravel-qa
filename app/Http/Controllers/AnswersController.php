<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;

class AnswersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }
 
    public function index(Question $question)
    {
        //use with is called eagar load.
        return $question->answers()->with('user')->simplePaginate(3);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, Request $request)
    {
        //
        $answer = $question->answers()->create( $request->validate([
            'body' => 'required'
        ]) + [ 'user_id' => \Auth::id()]);

        if($request->expectsJson())
        {
            return response()->json([
                'message' => 'Your answer has been submitted successfully',
                'answer' => $answer->load('user')
            ]);
        }

        return redirect()->back()->with('success', 'Your answer has been submitted successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);
        return view('answers.edit', compact('question', 'answer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        $answer->update($request->validate([
            'body' => 'required'
        ]));

        if($request->expectsJson())
        {
            return response()->json([
                'message' => 'Your answer was updated',
                'body_html' => $answer->body_html
            ]);
        }
         return redirect()->route('question.show', $question->slug)->with('success', 'Your answer was updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Answer $answer)
    {
        $this->authorize('delete', $answer);
        $answer->delete();
        if(request()->expectsJson())
        {
            return response()->json([
                'message' => 'Your answer was deleted'
            ]);
        }
        return back()->with('success', 'Your answer was deleted');
    }

}
