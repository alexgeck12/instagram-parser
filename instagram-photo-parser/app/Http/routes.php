<?php

Route::get('/', function () {
    return view('index');
});

Route::get('/users','usersController@getUsers');

Route::get('/user/{id}', 'userController@getUser');

Route::post('/','grabController@postGrab');