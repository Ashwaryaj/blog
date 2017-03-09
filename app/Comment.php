<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	//Fillable defined to avoid mass assignment exception
	protected $fillable = array('body', 'user_id', 'post_id');
    
	//a comment can only belong to one post
    public function post()
    {
    	return $this->belongsTo(Post::class);
    }

    //a comment can only belong to one user
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
