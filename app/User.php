<?php

namespace App;

use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Post;

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
     
       Mail::send('email.userverification',
         ['verification_code' => $this->verification_code],
         function ($message) {
             $message->to($this->email)
               ->subject('Please verify your email');
             return true;
         });
     
    }
}
