<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Post;

use App\User;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }
    //Create a post
    public function create()
    {
    	return view('posts.create');
    }
    //Render posts
    public function index()
    {
        $posts=Post::latest()->paginate() ;
        return view('posts.index',compact('posts'));
    }
    //Display a post
    public function show(Post $post)
    {
     	return view('posts.show',compact('post'));
    }
    //Store post in database
    public function store()
    {
        $this->validate(request(),[
            'title'=> 'required',
            'body'=>'required'
        ]);

        auth()->user()->publish(
            new Post(request(['title','body']))
        );
    	return redirect('/')->with('alert',"Post created successfully.");;
    }
}
