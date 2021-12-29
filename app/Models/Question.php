<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    use HasFactory;

    protected $fillables = ['title', 'body'];

    public function user () {
        return $this->belongsTo('App\Models\User');
    }

    public function setTitleAttribute ($value) {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getUrlAttribute() {
        return route('question.show', $this->id);
    }

    public function getCreatedDateAttribute() {
        return $this->created_at->diffForHumans();
    }
}
