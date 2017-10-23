<?php

Route::get('', function(){
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/threads', 'ThreadsController@index');
Route::get('/threads/create', 'ThreadsController@create');
Route::post('/threads', 'ThreadsController@store');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');
//Route::resource('threads', 'ThreadsController');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');
