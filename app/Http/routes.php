<?php

Route::auth();

Route::get('/', 'HomeController@index');

Route::get('/podcast/{podcastId}', 'HomeController@podcast');


Route::get('profile/{user?}', 'ProfileController@index');



Route::get('ajax/home', 'HomeController@ajaxHome');
Route::get('ajax/homeNoFeeds', 'HomeController@ajaxHomeNoFeeds');
Route::get('ajax/sidebar', 'HomeController@ajaxSidebar');
Route::get('ajax/followPodcast/{feedId}', 'HomeController@ajaxFollowPodcast');
Route::get('ajax/unfollowPodcast/{feedId}', 'HomeController@ajaxUnfollowPodcast');

Route::get('ajax/followUser/{username}', 'ProfileController@ajaxFollowUser');
Route::get('ajax/unfollowUser/{username}', 'ProfileController@ajaxUnfollowUser');

Route::get('ajax/allFriends', 'FriendsController@all');
Route::get('ajax/touchUser', 'HomeController@ajaxTouchUser');


Route::get('feed/{searchInput}', function($searchInput){
    $source = 'http://brnapi.us-east-1.elasticbeanstalk.com/v1/feeds/name/' . $searchInput;
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
