<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionsController extends Controller
{	
	public function __construct(){

		$this->middleware('guest',['except'=>'destroy']);
	}
    //Create login form
    public function create(){

    	return view('sessions.create');	
    }
    //Logout functionality
    public function destroy(){

    	auth()->logout();
    	return redirect('/');
    }
    //Authenticate login
    public function store(){
    	//attempt to authenticate the user
    	if(!auth()->attempt(request(['email','password']))){
    		return back()->withErrors([
    			'message'=>'Please check your credentials and try again'
    		]);
    	}
    	return redirect('/');
    }
 
}
