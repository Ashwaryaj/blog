<?php
Route::get('/tags', 'Auth\TagsController@autocompleteTags');
Route::get('/logout','Auth\LoginController@destroy');
Route::get('/posts/tags/{tag}','Auth\TagsController@index');
Auth::routes();
Route::post('/posts/{slug}/comments','Auth\CommentsController@store');
Route::get('/', 'Auth\HomeController@index');
//allow authenticated AND verified users only to shop on website
Route::group(['middleware' => 'verified'], function () {
    Route::resource('posts','Auth\HomeController', ['except' => [
    'show'
	]]);
});
//denied verification route
Route::get('verifyemail', function(){
   return "Please check your email to verify your email address and start blogging";
	
});
//Handle verification
Route::get('user/verify/{verificationCode}' ,'Auth\LoginController@verifyEmail');
Route::get('/posts/{slug}','Auth\HomeController@show');
