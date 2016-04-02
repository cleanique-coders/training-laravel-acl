<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group([
		'prefix' => 'admin',
		'as' => 'admin::',
		'middleware' => [
			'web',
			// 'has_perm:_read-task,_create-task,_update-task,_delete-task'
		]
	],function(){
	Route::resource('tasks','TasksController');
});
