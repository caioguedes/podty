<?php

Route::get('/', function () {
    return view('home');
});

Route::get('/podcast/{name}', 'HomeController@podcast');


Route::auth();

Route::get('/home', 'HomeController@index');
