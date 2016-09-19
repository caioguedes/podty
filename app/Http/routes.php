<?php

Route::auth();

Route::get('/', 'HomeController@index');

Route::get('/podcast/{podcastId}', 'HomeController@podcast');


Route::get('profile', function(){
    return view('profile');
});



Route::get('ajax/home', 'HomeController@ajaxHome');
Route::get('ajax/sidebar', 'HomeController@ajaxSidebar');



Route::get('feed/{searchInput}', function($searchInput){
    $source = 'localhost:8081/v1/feeds/name/' . $searchInput;
    $curl = curl_init($source);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, 'brnbp' . ":" . 'brnbp');

    $data = curl_exec($curl);
    $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if (!$data || $status_code >= 400) {
        return [];
    }

    return $data;
});

Route::get('episode/{podcastId}/{term}', function($podcastId, $term){
    $source = 'localhost:8081/v1/episodes/feedId/' . $podcastId . '?term=' . $term;
    $curl = curl_init($source);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, 'brnbp' . ":" . 'brnbp');

    $data = curl_exec($curl);
    $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if (!$data || $status_code >= 400) {
        return [];
    }

    return $data;
});
