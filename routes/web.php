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

Route::get('category/{category_id}', 'CategoryController@filter_assets')->name('category_filtered_assets');

// for user_requests
Route::get('/requests/category/{category_id}', 'UserRequestController@request_category')->name('request_category');
Route::get('requests/assign/{user_request}','UserRequestController@assign')->name('request_assign');
Route::get('requests/return/{user_request}','UserRequestController@return_page')->name('request_returnpage');
Route::put('requests/approve/{user_request}','UserRequestController@approve')->name('request_approve');
Route::put('requests/return/{user_request}','UserRequestController@return_asset')->name('request_return');

Route::resource('assets', 'AssetController');

Route::resource('vendors', 'VendorController');

Route::resource('categories', 'CategoryController');

Route::resource('user_requests', 'UserRequestController');

