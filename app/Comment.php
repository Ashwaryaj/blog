<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
 * @var array To avoid mass assignment exception 
*/
    protected $fillable = array('body', 'user_id', 'post_id');

    /**
     * A comment can only belong to one post
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * A comment can only belong to one user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
