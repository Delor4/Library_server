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
        Route::get('user', function (Request $request) {
                return response()->json(['success'=>$success], $request->user());
            });
        
        Route::get('book', 'BookController@index');
        Route::get('book/{id}', 'BookController@show');
        //Route::get('book/{id}', function($id) {
        //    return App\Book::find($id);
        //});
    });
    