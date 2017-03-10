<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;

class CommentsController extends Controller
{	//Create a comment
    public function store(Post $post){

    	$this->validate(request(), ['body' => 'required|min:3']);
		$post->addComment(request('body'));
		return back()->with('alert', 'Comment added');;

    }
}
