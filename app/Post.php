<?php

namespace App;

use Illuminate\Support\Facades\Auth;

class Post extends Model
{  
   //Post can have many comments
   public function comments(){
   		return $this->hasMany(Comment::class);
   }

   //A post can belong only to a single user
   public function user(){
      return $this->belongsTo(User::class);
   }
   //Function to add comments
   public function addComment($body){
      $user_id= Auth::id();
      $post_id= $this->id;
      $this->comments()->create(compact('body','user_id','post_id'));
   }
}
