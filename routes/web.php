<?php
Route::get('/tags', 'TagsController@autoComplete');
Route::get('/logout', 'Auth\LoginController@destroy');
Route::get('/posts/tags/{tag}', 'TagsController@index');
Route::get('/', 'Auth\PostController@index');
//allow authenticated AND verified users only to shop on website
Route::group(
    ['middleware' => 'verified'],
    function () {
        Route::resource(
            'posts',
            'Auth\PostController',
            ['except' => [
            'show'
            ]]
        );
        Route::post('/posts/{slug}/comments', 'CommentsController@store');
    }
);
Auth::routes();
//denied verification route
Route::get(
    'verifyemail',
    function () {
        return View::make('errors.NotVerified');
    }
);
//Handle verification
Route::get('user/verify/{verificationCode}', 'Auth\RegisterController@verifyEmail');
Route::get('/posts/{slug}', 'Auth\PostController@show');
Route::get(
    '/twittershare/{title}',
    function () {
        $link= Share::load('http://www.twitter.com', request()->title)->twitter();
        return redirect($link);
    }
);
Route::get(
    '/facebookshare/{title}',
    function () {
        $link= Share::load('http://www.facebook.com', request()->title)->facebook();
        return redirect($link);
    }
);
Route::get(
    '/gplusshare/{title}',
    function () {
        $link= Share::load('http://www.google.com', request()->title)->gplus();
        return redirect($link);
    }
);
Route::get('post/like/{id}', ['as' => 'post.like', 'uses' => 'LikeController@likePost']);
Route::get('post/like/{id}/delete', ['as' => 'post.deleteLike', 'uses' => 'LikeController@deleteLike']);
