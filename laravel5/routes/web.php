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

Route::group(['prefix'=>'api/v1'],function(){
    Route::resource('irisi','StdController',
    ['except' => ['edit','create']]);
    Route::post('user', ['uses' => 'AuthController@store']);
    Route::post('signin',['uses'=>'AuthController@signin']);
});
