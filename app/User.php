<?php

namespace App;

use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Post;
use Illuminate\Mail\Mailer;
use App\Http\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

use Mail;
use Illuminate\Support\Facades\Input;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','confirmation_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    //A  user can have many posts
    public function posts(){
        return $this->hasMany(Post::class);
    } 
    //User publishes a post
    public function publish(Post $post){
        $post->slug=Str::slug(request()->title);
        $id=$post->id;
        $this->posts()->save($post);  
    } 

/**
*
* Send a verification email with link
*
* @return void
*/
    public function sendVerificationEmail()
    {
      
    //optionally check if the user has a verification code here
     
       Mail::send('mail.verify',
         ['confirmation_code' => $this->confirmation_code],
         function ($message) {
             $message->to($this->email)
               ->subject('Please verify your email');
             return true;
         });
     
    }
}
