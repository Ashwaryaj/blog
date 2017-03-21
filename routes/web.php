<?php
Route::get('/logout','Auth\LoginController@destroy');
/*Route::get('/register','Auth\RegisterController@create');
Route::post('/register','Auth\RegisterController@store');
Route::get('/login','Auth\LoginController@create');*/
Auth::routes();
//Route::post('/login','Auth\LoginController@store'); 
Route::post('/posts/{post}/comments','Auth\CommentsController@store');
Route::get('/', 'Auth\HomeController@index');
Route::get('/posts/{post}','Auth\HomeController@show')->where('post', '[0-9]+');
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
