<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Post;
use Illuminate\Mail\Mailer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Mail;

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
    /**
     * One to many relationship between user and posts
     */
    public function posts()
    {
        //A  user can have many posts
        return $this->hasMany(Post::class);
    }
    /**
     * User can publish a post or save in drafts
     *
     * @param Post $post Post object
     */
    public function publish(Post $post)
    {
        //User publishes a post
        $id=$post->id;
        $post->slug= $post->createSlug(request()->title, $id);
        $this->posts()->save($post);
        return $post;
    }

    /**
    * Send a verification email with link
    *
    * @return void
    */
    public function sendVerificationEmail()
    {

        //optionally check if the user has a verification code here
        Mail::send(
            'mail.verify',
            ['confirmation_code' => $this->confirmation_code],
            function ($message) {
                $message->to($this->email)
                    ->subject('Please verify your email');
                return true;
            }
        );
    }
    /**
     * Send acknowlegement mail to user
     *
     * @return boolean true
     */
    public function sendConfirmationEmail()
    {

        //Send the user a mail that he is verified
        Mail::send(
            'mail.confirmation',
            [],
            function ($message) {
                $message->to($this->email)
                    ->subject('Thank You');
                return true;
            }
        );
    }
    public function likedPosts()
    {
        return $this->morphedByMany('App\Post', 'likeable')->whereDeletedAt(null);
    }
}
