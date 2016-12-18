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

Route::group(['as' => 'backend.', 'middleware' => 'auth', 'namespace' => 'Backend', 'prefix' => 'backend'], function() {

    // Dashboard
    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);

   // Verb    Path                        Action  Route Name
   // GET     /lpz                        index   lpz.index
   // GET     /lpz/create                 create  lpz.create
   // POST    /lpz                        store   lpz.store
   // GET     /lpz/{lpz}                  show    lpz.show
   // GET     /lpz/{lpz}/edit             edit    lpz.edit
   // PUT     /lpz/{lpz}                  update  lpz.update
   // DELETE  /lpz/{lpz}                  destroy lpz.destroy
    Route::resource('lpz', 'LpzController');

    Route::resource('work', 'WorkController');

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
