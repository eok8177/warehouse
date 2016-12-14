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

// Backend

Route::get('backend', function () {
    return redirect('backend/dashboard');
});

Route::group(['namespace' => 'Backend', 'prefix' => 'backend', 'middleware' => 'auth'], function() {

    // Dashboard
    Route::get('dashboard',       ['as' => 'backend.dashboard', 'uses' => 'DashboardController@index']);
    Route::post('dashboard/save', ['as' => 'backend.save',      'uses' => 'DashboardController@save']);
});

// Frontend

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');


Route::get('/migrate', function()
{
    $exitCode = Artisan::call('migrate');
});
