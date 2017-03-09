<?php

Route::resource('posts', 'PostsController');
Route::resource('/', 'PostsController');
Route::post('/posts/{post}/comments','CommentsController@store');
Route::get('/login','SessionsController@create');
Route::post('/login','SessionsController@store');
Route::get('/logout','SessionsController@destroy');
Route::get('/register','RegistrationController@create');
Route::post('/register','RegistrationController@store');



//Auth::routes();

//Route::get('/home', 'HomeController@index');
