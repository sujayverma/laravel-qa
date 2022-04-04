<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
        This Created Relation with Question Model.
     */
    public function questions () 
    {
        return $this->hasMany('App\Models\Question');
    }

    /*
        This Created Relation with Answer Model.
     */
    public function answers ()
    {
        return $this->hasMany('App\Models\Answer');
    }

    /*
        This creates many to many relationship between questions and users and stores it in favorites tables.
     */
    public function favorites ()
    {
        return $this->belongsToMany('App\Models\Question', 'favorites')->withTimestamps(); // mention the table where relation is saved. // can 'user_id', 'question_id' 3rd and 4th parameter as foregin key columns name.
         // with timestamps is used for adding time stamp to favorites table.
    }

    /*
        This creates many to many relationship between questions and users and stores it in vaotables tables.
     */
    public function voteQuestions ()
    {
        return $this->morphedByMany('App\Models\Question', 'votable')->withTimestamps(); // The table name need to be provides in singlur so that elquoent can reconize column votable_id, votable_type.
    }

     /*
        This creates many to many relationship between answers and users and stores it in vaotables tables.
     */
    public function voteAnswers ()
    {
        return $this->morphedByMany('App\Models\Answer', 'votable')->withTimestamps(); // The table name need to be provides in singlur so that elquoent can reconize column votable_id, votable_type.
    }

     /*
        This Sets url accessor to access value in views.
     */
    public function getUrlAttribute() 
    {
        // return route('questions.show', $this->id);
        return '#';
    }

     /*
        This Sets url accessor to access value in views.
     */
    public function getAvatarAttribute() 
    {
        $email = $this->email;
        $size = 30;
        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;
    }

    /*
        This has all the votes logic like how the user votes and other stuff.
     */
    public function voteTheQuestion (Question $question, $vote)
    {
        $voteQuestions = $this->voteQuestions();
        if( $voteQuestions->where('votable_id', $question->id)->exists() )
        {
            $voteQuestions->updateExistingPivot($question, ['vote' => $vote]);
        }
        else
        {
            $voteQuestions->attach($question, ['vote' => $vote]);
        }

        $question->load('vote'); // Update the votes value.
        $downVotes = (int) $question->downVotes()->sum('vote');
        $upVotes = (int) $question->upVotes()->sum('vote');
        $question->votes_count = $upVotes + $downVotes;
        $question->save();
    }
}
