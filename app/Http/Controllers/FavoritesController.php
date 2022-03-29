<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class FavoritesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth'); // check if the user is authorized or sign in.
    }

    public function store (Question $question)
    {
        $question->favorites()->attach( auth()->id() );
        return back();
    }

    public function destroy (Question $question)
    {
        $question->favorites()->detach( auth()->id() );
        return back();
    }
}
