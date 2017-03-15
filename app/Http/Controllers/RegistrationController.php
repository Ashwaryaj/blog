<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

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
    		'password'=>'required|confirmed|min:6'
    		]);
        $confirmation_code = str_random(30);
        console.log($confirmation_code); die();

        //Create and save them
        $user = User::create([
        'name' => request('name'),
        'email' => request('email'),
        'password' => bcrypt(request('password')),
        'confirmation_code' => $confirmation_code
        ]);

                Mail::send('mail.userverification', $confirmation_code, function($message) {
            $message->to(request('email'), request('name'))
                ->subject('Verify your email address');
        });

        Flash::message('Thanks for signing up! Please check your email.');

        return redirect('/');
        //Login
    	//auth()->login($user);
        //Redirect to home page
    	//return redirect('/')->with('alert','Thanks for signing up');
    }
}
