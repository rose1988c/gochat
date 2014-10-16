<?php
Route::get('/', function ()
{
    return View::make('hello');
});

Route::group(array (
    'prefix' => 'cron' 
), function ()
{
    Route::get('/', function ()
    {
        return View::make('hello');
    });
});
Route::get('/chat', 'ChatController@index');
