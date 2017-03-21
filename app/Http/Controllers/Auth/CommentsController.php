<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Post;
use App\Comment;

class CommentsController extends Controller
{	//Create a comment
    public function store(Post $post){
    	
    	$this->validate(request(), ['body' => 'required|min:3']);
		$post->addComment(request('body'));
		return back()->with('alert', 'Comment added');
    }
}
