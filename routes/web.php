<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'Auth\LoginController@showLoginForm');

Auth::routes();

Route::post('upload_avatar', 'Auth\RegisterController@ajaxUploadFile')->name('user.upload.avatar');

Route::group(['middleware' => 'auth'], function () {
    Route::prefix('contact')->group(function () {
        Route::get('/', 'ContactController@index')->name('contact');
        Route::get('/add', 'ContactController@add')->name('contact.add');
        Route::get('contact.add_request/{id}', 'ContactController@addRequest')->name('contact.add_request');
        Route::get('show/{id}', 'ContactController@show')->name('contact.show');

        Route::post('accept/{id}', 'ContactController@acceptRequest')->name('contact.accept');
        Route::post('reject/{id}', 'ContactController@rejectRequest')->name('contact.reject');

        Route::post('/ajax_search', 'ContactController@index')->name('contact.ajaxSearch');
        Route::post('/ajax_add_search', 'ContactController@add')->name('contact.addSearch');
    });
    
    Route::group(['prefix'=>'chat'], function() {
        Route::get('/', 'UserChatController@index')->name('chat');
        Route::get('/room/{room?}', 'UserChatController@room')->name('chat.room');
        Route::post('/sendMessage', 'UserChatController@sendMessage')->name('chat.sendMessage');
        Route::post('/getMessages', 'UserChatController@getMessages')->name('chat.getMessages');
        Route::post('/ajaxFileUpload', 'UserChatController@ajaxFileUpload')->name('chat.ajaxFileUpload');
        Route::get('/download/{id}', 'UserChatController@download')->name('chat.download');
        Route::post('/deleteFile/', 'UserChatController@deleteFile')->name('chat.deleteFile');
    });

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/profile', 'UserController@show')->name('profile');
    Route::post('/update', 'UserController@udpate')->name('update.avatar');
    
});


