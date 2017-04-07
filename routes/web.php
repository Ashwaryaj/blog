<?php
Route::get('/tags', 'TagsController@autoComplete');
Route::get('/logout','Auth\LoginController@destroy');
Route::get('/posts/tags/{tag}','TagsController@index');
Route::get('/', 'Auth\PostController@index');
//allow authenticated AND verified users only to shop on website
Route::group(['middleware' => 'verified'], function () {
    Route::resource('posts','Auth\PostController', ['except' => [
    'show'
	]]);
Route::post('/posts/{slug}/comments','CommentsController@store');
});
Auth::routes();
//denied verification route
Route::get('verifyemail', function(){
   return View::make('errors.NotVerified');
	
});
//Handle verification
Route::get('user/verify/{verificationCode}' ,'Auth\LoginController@verifyEmail');
Route::get('/posts/{slug}','Auth\PostController@show');
