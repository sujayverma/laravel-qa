<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;

class AcceptAnswerController extends Controller
{
    // This is default action invoked for a single method controller.
    public function __invoke(Answer $answer)
    {
        $this->authorize('accept', $answer);
        $answer->question->acceptBestAnswer($answer);
        return back();
    }
}
