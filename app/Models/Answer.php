<?php

namespace App\Models;

use App\Traits\VotableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    use VotableTrait;
    
    protected $fillable = ['body', 'user_id'];
    protected $appends = ['created_date', 'body_html','is_best'];
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
        This Sets body_html accessor to access value in views.
     */
    public function getBodyHtmlAttribute()
    {
       return \Purifier::clean(\Parsedown::instance()->text($this->body));
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
