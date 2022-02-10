<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

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
       return \Parsedown::instance()->text($this->body);
    }

    /*
        This Sets created_date accessor to access value in views.
     */
    public function getCreatedDateAttribute() 
    {
        return $this->created_at->diffForHumans();
    }

    public static function boot()
    {
        parent::boot();

        static::created( function ($answer) {
            $answer->question->increment('answers_count');
        });
    }
}
