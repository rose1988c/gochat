<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

<<<<<<< HEAD
Route::group(array('prefix' => 'cron'), function(){

    Route::get('/', function()
    {
	return View::make('hello');
    });

    });
=======
Route::get('/chat', 'ChatController@index');
>>>>>>> 51ca7a3172409ce74f5cbac4de46768573c3104c
