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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', 'APIController@getIndex');

//Authentication
Route::get('signup', 'APIController@getSignup');
Route::post('signup', 'APIController@postSignup');
Route::get('forgot-password', 'APIController@getForgotPassword');
Route::post('forgot-password', 'APIController@postForgotPassword');
Route::get('reset', 'APIController@getPasswordReset');
Route::post('reset', 'APIController@postPasswordReset');
Route::get('hello', 'APIController@getHello');
Route::post('hello', 'APIController@postHello');
Route::get('bye', 'APIController@getBye');

//Messages
Route::get('postman', 'APIController@getPostman');
Route::post('postman', 'APIController@postPostman');
Route::get('messages', 'APIController@getMessages');

Route::get('tb', 'APIController@getTestBomb');


