<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [ 'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            ]
        );
    }

    /**
     * Create a user and send an email to verify him
     * @param  array  $data User data
     * @return User object       User object
     */
    protected function create(array $data)
    {
        //Create a user
        try {
            $user=User::create(
                [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'confirmation_code' => str_random(30)
                ]
            );
        } catch (\Exception $e) {
            return redirect('');
        }
        $user->sendVerificationEmail();
        redirect('/')->with('message', 'Check your email to verify yourself.');
        return $user;
    }
    /**
     * Verify the user
     *
     * @param  Request $request          Receives request object
     * @param  string  $verificationCode Receives 30 char random token
     * @return Response                    Home page with or without message
     */
    public function verifyEmail(Request $request, $verificationCode)
    {
        $conditions = [
         'confirmation_code' => $verificationCode
        ];
        $valid = User::where($conditions)->first();
        //check if verificationCode exists
        if (!$valid) {
            return redirect('/')->withErrors(
                ["That verification code
            does not exist, try again"]
            );
        }

        $conditions = [
         'verified' => 0,
         'confirmation_code' => $verificationCode
        ];

        $valid = User::where($conditions)->first();

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
