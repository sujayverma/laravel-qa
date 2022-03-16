<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body'];

    /*
        This Created Relation with User Model.
     */    
    public function user () 
    {
        return $this->belongsTo('App\Models\User');
    }

    /*
        This Created Relation with Answer Model.
     */ 
    public function answers ()
    {
        return $this->hasMany('App\Models\Answer');
    }

    /*
        This Sets value for slug to store in DB.
     */
    public function setTitleAttribute ($value) 
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /*
        This Sets url accessor to access value in views.
     */
    public function getUrlAttribute() 
    {
        return route('question.show', $this->slug);
    }

    /*
        This Sets created_date accessor to access value in views.
     */
    public function getCreatedDateAttribute() 
    {
        return $this->created_at->diffForHumans();
    }

     /*
        This Sets status accessor to access value in views.
     */
    public function getStatusAttribute() 
    {
        if($this->answers_count > 0){
            if($this->best_answer_id)
                return 'answer-accepted';
            return 'answered';
        }
        return 'unanswered';
    }

     /*
        This Sets body_html accessor to access value in views.
     */
    public function getBodyHtmlAttribute()
    {
       return \Parsedown::instance()->text($this->body);
    }

    public function acceptBestAnswer( $answer )
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

}
