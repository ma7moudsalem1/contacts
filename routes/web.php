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

Route::get('/', 'HomeController@welcome')->name('welcome');

Auth::routes();



Route::group(['middleware' => ['auth']], function(){

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/auth', 'HomeController@auth')->name('auth');
    Route::apiResource('/contacts', 'Api\ContactController');

});

Route::get('{path}',"HomeController@welcome")->where('path', '([A-z\d-\/_.]+)?');