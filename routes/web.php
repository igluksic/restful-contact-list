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

Route::get('/login', function() {
    return view('loginpage');
});

//All protected routes in this group please
Route::group(['middleware' => 'check.oauth.token'], function() {

    Route::get('/', [
            'as' => 'homepage',
            'uses' => 'HomeController@home'
        ]
    );

    Route::post('/login', [
        'as' => 'login.post',
        'uses' => 'LoginController@userLogin'
    ]);

    Route::get('/logout', [
        'as' => 'logout',
        'uses' => 'LoginController@userLogout'
    ]);


    Route::get('/contact/new', function () {
        return view('contacts.new');
    });

    Route::get('/contact/edit/{id?}', [
        'as' => 'contact.edit',
        'uses' => 'HomeController@editContact'
    ]);

    Route::get('/contact/view/{id?}', [
        'as' => 'contact.view',
        'uses' => 'HomeController@viewContact'
    ]);

    Route::get('/contact/delete/{id}', [
        'as' => 'contact.delete',
        'uses' => 'UIController@delete'
    ]);

    Route::post('/contact/new', [
        'as' => 'contact.new',
        'uses' => 'UIController@new'
    ]);

    Route::post('/contact/edit/{id}', [
        'as' => 'contact.edit.post',
        'uses' => 'UIController@edit'
    ]);

    Route::get('/contact/{contactId}/deletephone/{phoneId}', [
        'as' => 'delete.phone',
        'uses' => 'UIController@deletePhoneNumber'
    ]);
});