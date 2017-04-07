<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tag;
use App\Post;

/**
 * Controller to handle tags
 */
class TagsController extends Controller
{
    /**
     * Show all post with particular tags
     *
     * @param  Tag $tag Tag string
     * @return Response View for posts
     */
    public function index(Tag $tag)
    {
        //Show tags
        $posts=$tag->posts()->latest()->paginate(3);
        return view('posts.index', compact('posts'));
    }

    /**
     *For smart search
     *
     * @param  Request $request Accept ajax request
     * @return Response Return json format or invalid request view
     */
    public function autoComplete(Request $request)
    {
        //Accept ajax request and returning json for tags
        if ($request->ajax()) {
            $name=$request->query('query');
            $tags=Tag::where('name', 'like', '%' . $name . '%')->get();
            return json_encode($tags->toArray());
        } else {
            return View::make('errors.InvalidRequest');
        }
    }
    /**
     * Save description
     *
     * @param Request $request Accept request containing body,title,tags,hidden-tags
     * @param integer $post_id Accept id of the post
     */
    public function save(Request $request, $post_id)
    {
        //Saving tags in tags table and pivot table
        $post=$request->toArray();
        $tags=explode(',', $post["hidden-tags"]);
        foreach ($tags as $tag) {
            $t = Tag::where('name', $tag)->first();
            if (is_null($t)) {
                //Insert into database
                $temp = new Tag;
                $temp->name =$tag;
                $temp->save();
            } else {
                $temp= Tag::where('name', $tag)->first();
            }

            $post = Post::where('id', $post_id)->firstOrFail();
            $post->tags()->attach($temp->id);
        }
    }
}
