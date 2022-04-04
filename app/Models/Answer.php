<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'user_id'];

    /*
        This Created Relation with Question Model.
     */
    public function question ()
    {
        return $this->belongsTo('App\Models\Question');
    }

    /*
        This Created Relation with User Model.
     */
    public function user ()
    {
        return $this->belongsTo('App\Models\User');
    }

    /*
        This creates many to many relationship between questions and users and stores it in vaotables tables.
     */
    public function vote ()
    {
        return $this->morphToMany('App\Models\User', 'votable');
    }

    /*
        This Sets body_html accessor to access value in views.
     */
    public function getBodyHtmlAttribute()
    {
       return \Parsedown::instance()->text($this->body);
    }

    /*
        This Sets created_date accessor to access value in views.
     */
    public function getCreatedDateAttribute() 
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        return $this->isBest() ? 'vote-accepted' : '';
    }

    public function getIsBestAttribute()
    {
        return $this->isBest();
    }

    public function isBest()
    {
        return $this->id === $this->question->best_answer_id;
    }

    public static function boot()
    {
        parent::boot();

        static::created( function ($answer) {
            $answer->question->increment('answers_count');
        });

        static::deleted( function( $answer ){
            $question = $answer->question;
            $question->decrement('answers_count');
            if($question->best_answer_id  === $answer->id)
            {
                $question->best_answer_id = NULL;
                $question->save();
            }
        });
    }
}
