<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class RegistrationController extends Controller
{   
    //Create registration form
    public function create(){

    	return view('registration.create');	
    }

    //Validate and store the user in database
    public function store(){
        //Validate the user
    	$this->validate(request(),[
    		'name'=>'required',
    		'email'=>'required|email',
    		'password'=>'required|confirmed'
    		]);
        //Create and save them
        $user = User::create([
        'name' => request('name'),
        'email' => request('email'),
        'password' => bcrypt(request('password'))
        ]);
        //Login
    	auth()->login($user);
        //Redirect to home page
    	return redirect('/')->with('alert','Thanks for signing up');;
    }
}
