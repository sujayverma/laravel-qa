<?php

namespace App\Models;

use App\Traits\VotableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    use HasFactory;
    use VotableTrait;
    protected $fillable = ['title', 'body'];
    protected $appends = ['created_date', 'is_favorited', 'favorite_count', 'body_html'];
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
        return $this->hasMany('App\Models\Answer')->orderBy('votes_count', 'DESC');
    }

    /*
        This creates many to many relationship between questions and users and stores it in favorites tables.
     */
    public function favorites ()
    {
        return $this->belongsToMany('App\Models\User', 'favorites')->withTimestamps(); // mention the table where relation is saved. // can 'question_id', 'user_id' 3rd and 4th parameter as foregin key columns name.
        // with timestamps is used for adding time stamp to favorites table.
    }

    
     /*
        This return if the question is favorited by user or not.
     */
    public function isFavorited ()
    {
        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

    /*
        This is accessor returns if the question is favorited or not.
     */
    public function getIsFavoritedAttribute ()
    {   
        // \DB::enableQueryLog();
        // echo 'hi'.$this->favoritses()->where('user_id', auth()->id())->count();
        // dd($this->favorites);
        // dd(\DB::getQueryLog());
        return $this->isFavorited();
    }

    /*
        This returns the favorate count.
     */
    public function getFavoriteCountAttribute ()
    {
        return $this->favorites->count();
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
       return \Purifier::clean($this->bodyHtml());
    }

     /*
        This saves the best answer.
     */
    public function acceptBestAnswer( $answer )
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    /*
        This Sets excerpt accessor to access value in views.
     */
    public function getExcerptAttribute()
    {
        return $this->excerpt(250);
    }

    /*
        This Sets excerpt and it's length.
     */
    public function excerpt($length)
    {
        return Str::limit(strip_tags($this->bodyHtml()), $length );
    }

    /*
        This returns question body text..
     */
    private function bodyHtml()
    {
        return \Parsedown::instance()->text($this->body);
    }

    

}
