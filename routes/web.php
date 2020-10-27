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
    return view('auth.login');
});


Auth::routes();

Route::get('logout', function () {
    Auth::logout();
    return view('auth.login');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/emailsView', 'ManageCommunicationController@emailsView')->name('emailsView');
Route::get('/smsView', 'ManageCommunicationController@smsView')->name('smsView');
Route::get('/sendEmail/{id}', 'ManageCommunicationController@sendEmail')->name('sendEmail');
Route::get('/sendSms/{id}', 'ManageCommunicationController@sendSms')->name('sendSms');
Route::get('walk_in', 'ManageCommunicationController@walk_in')->name('walk_in');
