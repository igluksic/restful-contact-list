<?php

use Illuminate\Http\Request;

Route::post('auth/login', [
    'as' => 'auth.login',
    'uses' => 'AuthController@auth'
]);

Route::post('/test', [
    'as' => 'test',
    'uses' => 'HomeController@test'
]);



Route::group(['middleware' => 'jwt.auth'], function() {
    Route::get('/contacts', [
        'as' => 'contact.list',
        'uses' => 'ContactApiController@index'
    ]);
    Route::get('/contact/{id}', [
        'as' => 'contact.show',
        'uses' => 'ContactApiController@show'
    ]);

    Route::post('/contact', [
        'as' => 'post.contact',
        'uses' => 'ContactApiController@store']
    );

    Route::put('/contact/{id}', [
        'as' => 'put.contact',
        'uses' => 'ContactApiController@update'
    ]);

    Route::delete('/contact/{id}', [
        'as' => 'delete.contact',
        'uses' => 'ContactApiController@destroy'
    ]);

    Route::get('/phone/{id}', [
        'as' => 'phone.show',
        'uses' => 'PhoneApiController@show'
    ]);

    Route::post('/phone/{contactId}', [
        'as' => 'phone.post',
        'uses' => 'PhoneApiController@store'
    ]);

    Route::put('/phone/{id}', [
        'as' => 'phone.put',
        'uses' => 'PhoneApiController@update'
    ]);

    Route::delete('/phone/{id}',
        [
            'as' => 'phone.delete',
            'uses' => 'PhoneApiController@destroy'
        ]);
});