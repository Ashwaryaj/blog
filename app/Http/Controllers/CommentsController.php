<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Post;

/**
 * Controller to handle comments
 */
class CommentsController extends Controller
{
    /**
     * Stores the comment
     *
     * @param  String Post slug
     * @return Response Returns to previous page
     */
    public function store($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $this->validate(request(), ['body' => 'required|min:3']);
        $post->addComment(request('body'));
        return back()->with('alert', 'Comment added');
    }
}
