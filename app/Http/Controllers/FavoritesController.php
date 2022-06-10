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

        if(request()->expectsJson())
            return response()->json(null, 204);
            
        return back();
    }

    public function destroy (Question $question)
    {
        $question->favorites()->detach( auth()->id() );

        if(request()->expectsJson())
            return response()->json(null, 204);

        return back();
    }
}
