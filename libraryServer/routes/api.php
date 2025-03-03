<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

    Route::post('login', 'API\UserController@login')->name('do_login');
    Route::post('register', 'API\UserController@register');
    Route::group(['middleware' => 'auth:api'], function(){
        Route::post('details', 'API\UserController@details');
        /* Route::get('user', function (Request $request) {
                return response()->json(['success'=>$success], $request->user());
            }); */
        Route::resource('user', 'API\UserController',  ['except' => [ 'edit', 'create' ]]);
        
        Route::resource('title', 'TitlesController',  ['except' => [ 'edit', 'create' ]]);
        Route::resource('book', 'BookController',  ['except' => [ 'edit', 'create' ]]);
        Route::resource('reservation', 'ReservationsController',  ['except' => [ 'edit', 'create', 'update']]);
        Route::resource('rent', 'RentsController',  ['except' => [ 'edit', 'create', 'update']]);
        
    });
    