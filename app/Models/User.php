<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
}
