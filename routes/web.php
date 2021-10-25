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

Route::get('/', 'MainController@getIndex');
Route::get('temp', 'MainController@getTemp');

//Authentication
Route::get('signup', 'LoginController@getSignup');
Route::post('signup', 'LoginController@postSignup');
Route::get('forgot-password', 'LoginController@getForgotPassword');
Route::post('forgot-password', 'LoginController@postForgotPassword');
Route::get('reset', 'LoginController@getPasswordReset');
Route::post('reset', 'LoginController@postPasswordReset');
Route::get('hello', 'LoginController@getHello');
Route::post('hello', 'LoginController@postHello');
Route::get('bye', 'LoginController@getBye');
Route::get('oauth', 'LoginController@getOauth');
Route::get('{type}/oauth', 'LoginController@getOauthRedirect');
Route::get('oauth-sp', 'LoginController@getOAuthSP');
Route::post('oauth-sp', 'LoginController@postOAuthSP');
Route::get('gu', 'MainController@getUsername');

//Users
Route::get('users', 'AdminController@getUsers');
Route::get('new-user', 'AdminController@getAddUser');
Route::post('new-user', 'AdminController@postAddUser');
Route::get('user', 'AdminController@getUser');
Route::post('user', 'AdminController@postUser');
Route::get('edu', 'AdminController@getEnableDisableUser');

//Webmail
Route::get('inbox', 'MainController@getInbox');
Route::get('new-message', 'MainController@getNewMessage');
Route::post('new-message', 'MainController@postNewMessage');
Route::get('drafts', 'MainController@getDrafts');
Route::get('sent', 'MainController@getSent');
Route::get('trash', 'MainController@getTrash');
Route::get('spam', 'MainController@getSpam');
Route::get('message', 'MainController@getMessage');
Route::get('dl', 'MainController@getDownload');
Route::post('message', 'MainController@postMessage');
Route::get('settings', 'MainController@getSettings');
Route::post('settings', 'MainController@postSettings');

//Plugins
Route::get('plugins', 'AdminController@getPlugins');
Route::get('add-plugin', 'AdminController@getAddPlugin');
Route::post('add-plugin', 'AdminController@postAddPlugin');
Route::get('plugin', 'AdminController@getPlugin');
Route::post('plugin', 'AdminController@postPlugin');
Route::get('remove-plugin', 'AdminController@getRemovePlugin');

//Banners
Route::get('banners', 'AdminController@getBanners');
Route::get('add-banner', 'AdminController@getAddBanner');
Route::post('add-banner', 'AdminController@postAddBanner');
Route::get('update-banner', 'AdminController@getUpdateBanner');
Route::get('remove-banner', 'AdminController@getRemoveBanner');

//Tickets
Route::get('tickets', 'AdminController@getTickets');
Route::get('ticket', 'AdminController@getTicket');
Route::get('add-ticket', 'AdminController@getAddTicket');
Route::post('add-ticket', 'AdminController@postAddTicket');
Route::get('update-ticket', 'AdminController@getUpdateTicket');
Route::post('update-ticket', 'AdminController@postUpdateTicket');
Route::get('remove-ticket', 'AdminController@getRemoveTicket');

//Senders
Route::get('senders', 'AdminController@getSenders');
Route::get('add-sender', 'AdminController@getAddSender');
Route::post('add-sender', 'AdminController@postAddSender');
Route::get('sender', 'AdminController@getSender');
Route::post('sender', 'AdminController@postSender');
Route::get('remove-sender', 'AdminController@getRemoveSender');
Route::get('mark-sender', 'AdminController@getMarkSender');

//FAQs
Route::get('faqs', 'AdminController@getFAQs');
Route::get('add-faq', 'AdminController@getAddFAQ');
Route::post('add-faq', 'AdminController@postAddFAQ');
Route::get('faq', 'AdminController@getUpdateFAQ');
Route::get('remove-faq', 'AdminController@getRemoveFAQ');
Route::get('faq-tags', 'AdminController@getFAQTags');
Route::get('add-faq-tag', 'AdminController@getAddFAQTag');
Route::post('add-faq-tag', 'AdminController@postAddFAQTag');
Route::get('remove-faq-tag', 'AdminController@getRemoveFAQTag');


Route::get('zohoverify/{nn}', 'AdminController@getZoho');
Route::get('tb', 'AdminController@getTestBomb');
Route::get('t', 'MainController@getTest');

