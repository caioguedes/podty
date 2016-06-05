<?php

Route::get('/', 'HomeController@index');

Route::get('/podcast/{name}', 'HomeController@podcast');


Route::auth();

Route::get('/home', 'HomeController@index');
