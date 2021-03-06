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
// Verb    Path                        Action  Route Name
// GET     /lpz                        index   lpz.index
// GET     /lpz/create                 create  lpz.create
// POST    /lpz                        store   lpz.store
// GET     /lpz/{lpz}                  show    lpz.show
// GET     /lpz/{lpz}/edit             edit    lpz.edit
// PUT     /lpz/{lpz}                  update  lpz.update
// DELETE  /lpz/{lpz}                  destroy lpz.destroy


// Backend

Route::get('backend', function () {
  return redirect('backend/dashboard');
});

Route::group(['as' => 'backend.', 'middleware' => 'roles', 'roles' => 'admin', 'namespace' => 'Backend', 'prefix' => 'backend'], function() {

    // Dashboard
  Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);

  Route::resource('lpz', 'LpzController');

  Route::resource('work', 'WorkController');

});


Route::group(['as' => 'sklad.', 'middleware' => 'roles','roles' =>['admin', 'sklad'], 'namespace' => 'Sklad', 'prefix' => 'sklad'], function() {

  Route::get('/', 'DashboardController@index');

  Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);

  Route::resource('invoice',  'InvoiceController');
  Route::resource('product',  'ProductController');

// Catalogs
  Route::resource('bill',     'BillController');
  Route::resource('client',   'ClientController');
  Route::resource('supplier', 'SupplierController');

// Incoming
  Route::get('incoming/{invoice}', ['as' => 'incoming.create', 'uses' => 'IncomingController@create']);
  Route::post('incoming', ['as' => 'incoming', 'uses' => 'IncomingController@store']);
  Route::delete('incoming/{incoming}', ['as' => 'incoming.destroy', 'uses' => 'IncomingController@destroy']);

// Outcoming
  Route::get('outcoming/create/{product}',      ['as' => 'outcoming.create', 'uses' => 'OutcomingController@create']);
  Route::get('outcoming/{outcoming}/edit', ['as' => 'outcoming.edit', 'uses' => 'OutcomingController@edit']);
  Route::post('outcoming',               ['as' => 'outcoming.store', 'uses' => 'OutcomingController@store']);
  Route::delete('outcoming/{outcoming}', ['as' => 'outcoming.destroy', 'uses' => 'OutcomingController@destroy']);
  Route::put('outcoming/{outcoming}', ['as' => 'outcoming.update', 'uses' => 'OutcomingController@update']);

// Reports
  Route::get('report',  ['as' => 'report.index',  'uses' => 'ReportController@index']);
  Route::post('report', ['as' => 'report.simple', 'uses' => 'ReportController@simple']);
  Route::post('report/full', ['as' => 'report.full', 'uses' => 'ReportController@full']);
  Route::get('report/excel/{from}/{to}/{type}', ['as' => 'report.excel', 'uses' => 'ReportController@excel']);
  Route::get('report/excelsheets/{from}/{to}', ['as' => 'report.excelsheets', 'uses' => 'ReportController@excelsheets']);

});

// Apteka

Route::group(['as' => 'apteka.', 'middleware' => 'roles','roles' =>['admin', 'sklad'], 'namespace' => 'Apteka', 'prefix' => 'apteka'], function() {

  Route::get('/', 'DashboardController@index');

  Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);

  Route::resource('invoice',  'InvoiceController');
  Route::resource('product',  'ProductController');

// Catalogs
  Route::resource('bill',     'BillController');
  Route::resource('client',   'ClientController');
  Route::resource('supplier', 'SupplierController');

// Incoming
  Route::get('incoming/{invoice}', ['as' => 'incoming.create', 'uses' => 'IncomingController@create']);
  Route::post('incoming', ['as' => 'incoming', 'uses' => 'IncomingController@store']);
  Route::delete('incoming/{incoming}', ['as' => 'incoming.destroy', 'uses' => 'IncomingController@destroy']);

// Outcoming
  Route::get('outcoming/create/{product}/{incoming}',      ['as' => 'outcoming.create', 'uses' => 'OutcomingController@create']);
  Route::get('outcoming/{outcoming}/edit', ['as' => 'outcoming.edit', 'uses' => 'OutcomingController@edit']);
  Route::post('outcoming',               ['as' => 'outcoming.store', 'uses' => 'OutcomingController@store']);
  Route::delete('outcoming/{outcoming}', ['as' => 'outcoming.destroy', 'uses' => 'OutcomingController@destroy']);
  Route::put('outcoming/{outcoming}', ['as' => 'outcoming.update', 'uses' => 'OutcomingController@update']);

// Reports
  Route::get('report',  ['as' => 'report.index',  'uses' => 'ReportController@index']);
  Route::post('report', ['as' => 'report.simple', 'uses' => 'ReportController@simple']);
  Route::post('report/full', ['as' => 'report.full', 'uses' => 'ReportController@full']);
  Route::get('report/excel/{from}/{to}/{type}', ['as' => 'report.excel', 'uses' => 'ReportController@excel']);

});

// Frontend

Route::get('/', function () {
  // return view('welcome');
  return redirect('/home');
});

Auth::routes();

Route::get('/home', 'HomeController@index');


// Route::get('/migrate', function()
// {
//   $exitCode = Artisan::call('migrate');
// });

Route::get('/backup', function()
{
  $exitCode = Artisan::call('backup:run');
  // echo "<pre>".print_r($exitCode, true);
});
