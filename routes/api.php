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

Route::get('update-session', 'APIController@getUpdateSession');
Route::post('update-session', 'APIController@postUpdateSession');

Route::get('settings', 'APIController@getSettings');
Route::get('remove-sig', 'APIController@getRemoveSignature');
Route::post('settings', 'APIController@postSettings');

//Messages
Route::get('postman', 'APIController@getPostman');
Route::post('postman', 'APIController@postPostman');
Route::get('messages', 'APIController@getMessages');
Route::get('message', 'APIController@getMessage');
Route::post('message', 'APIController@postMessage');
Route::get('new-message', 'APIController@getNewMessage');
Route::post('new-message', 'APIController@postNewMessage');
Route::get('move-message', 'APIController@getMoveMessage');
Route::post('move-message', 'APIController@postMoveMessage');
Route::get('delete-message', 'APIController@getDeleteMessage');
Route::get('mark-unread', 'APIController@getMarkUnread');

Route::get('tb', 'APIController@getTestBomb');
Route::get('xx', 'APIController@getTest');

Route::post('sn','APIController@postSendNotification');
