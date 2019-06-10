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
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function(){
	Route::resource('countries','CountriesController');
	Route::resource('categories','CategoriesController');
	Route::resource('payment_methods','PaymentMethodsController');
	Route::resource('channels','ChannelsController');
	Route::resource('plans','PlansController');
	Route::resource('users','UsersController');
	Route::get('users/profile', 'UsersController@profile')->name('profile');
	Route::resource('payments','PaymentsController');
});
