<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Post;
use DB;

/**
 * Controller for operations related to post
 */
class PostController extends Controller
{
    /**
     * Post Constructor to apply Auth controller for required methods
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }

    /**
     * Create a post
     *
     * @return Response View posts.create
     */
    public function create()
    {
        //Create a post
        return view('posts.create');
    }

    /**
     * Show all the posts
     *
     * @return Response View posts.index
     */
    public function index()
    {
        //Render posts
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
    /**
     * Display a single post
     *
     * @param  String $slug Slug string
     * @return Response       View posts.show
     */
    public function show($slug)
    {
        //Display a post
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('posts.show', compact('post'));
    }
    /**
     * Store posts in database
     *
     * @param  Request $request Post
     * @return Response           Home page with alert
     */
    public function store(Request $request)
    {
        //Store post in database
        $this->validate(
            $request,
            ['title'=> 'required',
            'body'=>'required',
            ]
        );

        if ($request->input('hidden-tags')) {
            $this->validate(
                $request,
                ['hidden-tags'=> 'required']
            );
        }

        //Publish a post
        auth()->user()->publish(
            $post = new Post(
                $request->except(
                    'tags',
                    'hidden-tags',
                    'files'
                )
            )
        );

        //To save tags to database
        app('App\Http\Controllers\TagsController')->save($request, $post->id);
        return redirect('/')->with('alert', "Post created successfully.");
    }
    /**
     * Edit a post
     *
     * @param  String $slug Accepts a slug
     * @return Response       View with post parameter
     */
    public function edit($slug)
    {
        // get the post
        $post = Post::where('slug', $slug)->firstOrFail();
        // show the edit form and pass the post
        return View::make('posts.edit')
            ->with('post', $post);
    }
    /**
     * Update a post
     *
     * @param  String $slug Accepts a slug
     * @return Response       Redirects to home page
     */
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

    /**
     * Function to delete a post
     *
     * @param  String $slug Accepts a slug
     * @return Response       Redirects to home page
     */
    public function destroy($slug)
    {
        // delete
        $post = Post::where('slug', $slug)->firstOrFail();
        $post->delete();
        Session::flash('message', 'Successfully deleted the post!');
        return Redirect::to('/');
    }
}
