<?php
namespace App\Traits;

trait VotableTrait
{
    /*
        This creates many to many relationship between questions and users and stores it in vaotables tables.
     */
    public function vote ()
    {
        return $this->morphToMany('App\Models\User', 'votable');
    }

     /*
        This returns the up votes for a question.
     */
    public function upVotes ()
    {
        return $this->vote()->wherePivot('vote', 1);
    }

    /*
        This returns the down votes for a question.
     */
    public function downVotes ()
    {
        return $this->vote()->wherePivot('vote', -1);
    }
}
