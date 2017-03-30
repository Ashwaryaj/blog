<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;

use App\User;


class LoginController extends Controller
{   
    protected $redirectPath = '/';
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
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

    
 
    public function verifyEmail(Request $request, $verificationCode)
    {
        

       //check if verificationCode exists
       if (!$valid = User::where('confirmation_code', $verificationCode)->first()) {
        
           return redirect('/')->withErrors(["That verification code does not exist, try again"]);
       }
     
       $conditions = [
         'verified' => 0,
         'confirmation_code' => $verificationCode
       ];
     
       if ($valid = User::where($conditions)->first()) {
         
        $valid->verified = 1;
        $valid->save();
     
        return redirect('/')
             ->withInput(['email' => $valid->email]);
       }
     
       return redirect('/')->with('message',"Your account is already verified");
    }
 
}
