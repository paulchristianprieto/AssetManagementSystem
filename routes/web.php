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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/requests/category/{category_id}', 'UserRequestController@request_category')->name('request_category');
Route::get('requests/assign/{user_request}','UserRequestController@assign')->name('request_assign');
Route::put('requests/approve/{user_request}','UserRequestController@approve')->name('request_approve');

Route::resource('assets', 'AssetController');

Route::resource('vendors', 'VendorController');

Route::resource('categories', 'CategoryController');

Route::resource('user_requests', 'UserRequestController');

