<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => 'auth'], function () {

    # Index route
    Route::get('/home', 'HomeController@index')->name('home');

    # For resourceful project itself
    Route::resource('projects', 'ProjectsController');
    // Route::get('/projects', 'ProjectsController@index');
    // Route::get('/projects/create', 'ProjectsController@create');
    // Route::get('/projects/{project}', 'ProjectsController@show');
    // Route::get('/projects/{project}/edit', 'ProjectsController@edit');
    // Route::patch('/projects/{project}', 'ProjectsController@update');
    // Route::post('/projects', 'ProjectsController@store');
    // Route::delete('/projects/{project}', 'ProjectsController@destroy');

    # For project invitation

    Route::post('/projects/{project}/invitations', 'ProjectInvitationsController@store');

    # For tasks
    Route::post('/projects/{project}/tasks', 'ProjectTasksController@store');
    Route::patch('/projects/{project}/tasks/{task}', 'ProjectTasksController@update');
});
Auth::routes();