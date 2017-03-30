<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //Get the posts associated with each tag
    public function posts(){
    	return $this->belongsToMany(Post::class);
    }

    public function getRouteKeyName(){
    	return 'name';
    }
}
