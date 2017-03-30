<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

      $post_id= $this->id;
      $user_id= Auth::id();
      //dd($post_id, $user_id);
      $this->comments()->create(compact('body','user_id','post_id'));
   }

    public function tags(){
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

   public function scopeFilter($query, $filters) {

        if($month=$filters['month']) {
            $query->whereMonth('created_at',Carbon::parse($month)->month);
        }
        if($year=$filters['year']) {
            $query->whereYear('created_at',$year);
        }
   }

   public static function archives() {

      return static::selectRaw('year(created_at) year, monthname(created_at) month, count(*) published')
         ->groupBy('year','month')
         ->orderByRaw('min(created_at) desc')
         ->get()
         ->toArray();
   }
}
