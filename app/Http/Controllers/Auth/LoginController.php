<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;

/**
 * Controller for managing login
 */
class LoginController extends Controller
{

    protected $redirectPath = '/';
    /*
    |-----------------------------------------------------y---------------------
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
    public function __construct()
    {

        $this->middleware('guest', ['except'=>'destroy']);
    }

    public function create()
    {
        //Create login form
        return view('sessions.create');
    }

    public function destroy()
    {
        //Logout functionality
        auth()->logout();
        return redirect('/');
    }
    /**
     * Attempt to login
     *
     * @return Response Home Page
     */
    public function store()
    {
        //attempt to authenticate the user
        if (!auth()->attempt(request(['email','password']))) {
            return back()->withErrors(
                [
                'message'=>'Please check your credentials and try again'
                ]
            );
        }
        return redirect('/');
    }

    /**
     * Verify the user
     *
     * @param  Request $request          Receives token
     * @param  string  $verificationCode Receives 30 char random token
     * @return Response                    Home page with or without message
     */
    public function verifyEmail(Request $request, $verificationCode)
    {
        $conditions = [
         'verified' => 0,
         'confirmation_code' => $verificationCode
        ];
        $valid = User::where($conditions)->first();
        //check if verificationCode exists
        if (!$valid) {
            return redirect('/')->withErrors(
                ["That verification code
            does exist, try again"]
            );
        }

        if ($valid) {
            $valid->verified = 1;
            $valid->save();
            $valid->sendConfirmationEmail();
            return redirect('/')
             ->with('message', "Your account is verified");
        }

        return redirect('/')->with('message', "Your account is already verified");
    }
}
