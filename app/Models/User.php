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
    protected $appends = ['url', 'avatar'];
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
        This has all the votes logic for question like how the user votes and other stuff.
     */
    public function voteTheQuestion (Question $question, $vote)
    {
        $voteQuestions = $this->voteQuestions();
        return $this->_vote( $voteQuestions, $question, $vote);
    }

     /*
        This has all the votes logic for answer like how the user votes and other stuff.
     */
    public function voteTheAnswer (Answer $answer, $vote)
    {
        $voteAnswers = $this->voteAnswers();
        return $this->_vote( $voteAnswers, $answer, $vote);
    }

    private function _vote( $relationship, $method, $vote )
    {
        if( $relationship->where('votable_id', $method->id)->exists() )
        {
            $relationship->updateExistingPivot($method, ['vote' => $vote]);
        }
        else
        {
            $relationship->attach($method, ['vote' => $vote]);
        }

        $method->load('vote'); // Update the votes value.
        $downVotes = (int) $method->downVotes()->sum('vote');
        $upVotes = (int) $method->upVotes()->sum('vote');
        $method->votes_count = $upVotes + $downVotes;
        $method->save();
        return $method->votes_count;
    }
}
