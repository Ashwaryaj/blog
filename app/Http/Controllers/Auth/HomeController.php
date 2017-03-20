<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Post;
use Illuminate\Support\Facades\Session;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;


class HomeController extends Controller
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
        if(Auth::check()){
            $posts=auth()->user()->posts()->latest()->paginate(10);

        }
        else{
            $posts=Post::where('status','published')->latest()->paginate(10) ;
        }

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
            new Post(request()->all())
        );
        return redirect('/')->with('alert',"Post created successfully.");;
    }

    public function edit($id){
        // get the post
        $post = Post::find($id);

        // show the edit form and pass the post
        return View::make('posts.edit')
            ->with('post', $post);        
    }

    public function update($id){
        
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
            $post = Post::find($id);
            $post->title = Input::get('title');
            $post->body = Input::get('body');
            $post->status=Input::get('status');
            $post->save();

            // redirect
            Session::flash('message', 'Successfully updated post!');
            return Redirect::to('/');
        }
    }

    public function destroy($id){
        // delete
        $post = Post::find($id);
        $post->delete();
        Session::flash('message', 'Successfully deleted the post!');
        return Redirect::to('/');
    }
}
