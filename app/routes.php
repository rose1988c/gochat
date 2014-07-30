<?php
/**
 * routes.php
 * 
 * @author rose1988.c@gmail.com
 * @version 1.0
 * @date 2014-6-29 下午5:05:13
 */
Route::get('/', 'HomeController@index');

//------------------------------- 本地使用 -------------------------------
Route::group(array('before' => 'dev'), function()
{
    Route::get('/env', function(){return app::environment();});
});
