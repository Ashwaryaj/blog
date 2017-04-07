<?php

namespace App\Http\Controllers\Auth;

use App\Post;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class PostController extends Controller
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
        if (Auth::check()) {
            $posts=Post::where('status', 'published')
                ->orWhere('status', 'draft')
                ->filter(request(['month','year']))
                ->latest()
                ->paginate(2);
        } else {
            $posts=Post::where('status', 'published')
                ->filter(request(['month','year']))
                ->latest()
                ->paginate(2);
        }


        $archives=Post::archives();
        return view('posts.index', compact('posts'));
    }
    //Display a post
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('posts.show', compact('post'));
    }
    //Store post in database
    public function store(Request $request)
    {
        $this->validate(
            $request,
            ['title'=> 'required',
            'body'=>'required',
            'tags'=>'required'
            ]
        );

        //Publish a post
        auth()->user()->publish(
            new Post($request->except('tags', 'hidden-tags', 'files'))
        );
        //To save tags to database
        $id=DB::table('posts')->orderBy('id', 'desc')->first()->id;
        app('App\Http\Controllers\TagsController')->save($request, $id);
        return redirect('/')->with('alert', "Post created successfully.");
    }

    public function edit($slug)
    {
        // get the post
        $post = Post::where('slug', $slug)->firstOrFail();
        // show the edit form and pass the post
        return View::make('posts.edit')
            ->with('post', $post);
    }

    //Update a post
    public function update($slug)
    {
        // validate
        $rules = array(
            'title'       => 'required',
            'body'      => 'required',
            'status'      => 'required',

        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('posts/' . $id . '/edit')
                ->withErrors($validator);
        } else {
            // store
            $post = Post::where('slug', $slug)->firstOrFail();
            $post->title = Input::get('title');
            $post->body = Input::get('body');
            $post->status=Input::get('status');
            $post->save();

            // redirect
            Session::flash('message', 'Successfully updated post!');
            return Redirect::to('/');
        }
    }

    //Function to delete a postp
    public function destroy($slug)
    {
        // delete
        $post = Post::where('slug', $slug)->firstOrFail();
        $post->delete();
        Session::flash('message', 'Successfully deleted the post!');
        return Redirect::to('/');
    }
}
