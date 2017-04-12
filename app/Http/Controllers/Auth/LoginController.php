<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
    /**
     * Creating login screen
     * @return Response Sessions.create view
     */
    public function create()
    {
        //Create login form
        return view('sessions.create');
    }
    /**
     * Logout for an authenticated user
     * @return Response Redirect to home page
     */
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
}
