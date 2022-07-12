<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;

class VoteAnswerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke( Answer $answer )
    {
        $vote  = (int) request()->vote;

        $voteCount = auth()->user()->voteTheAnswer($answer, $vote);

        if(request()->expectsJson()) {
            return response()->json([
                'message' => "Thanks for your feedback",
                'voteCount' => $voteCount
            ]);
        }

        return back();
    }
}
