<?php

Auth::routes();
Route::get('/', 'HomeController@index');
Route::get('profile/{user?}', 'ProfileController@index');
Route::get('feed/{searchInput}', function($searchInput){

    $source = env('API_BASE_URL') . 'feeds/name/' . rawurlencode($searchInput);
    $curl = curl_init($source);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, env('API_AUTH_USER') . ":" . env('API_AUTH_PASS'));

    $data = curl_exec($curl);
    $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if (!$data || $status_code >= 400) {
        return [];
    }

    return $data;
});

Route::get('episode/{podcastId}/{term}', function($podcastId, $term){
    $source = env('API_BASE_URL') . 'feeds/'. $podcastId . '/episodes?term=' . $term;
    $curl = curl_init($source);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, env('API_AUTH_USER') . ":" . env('API_AUTH_PASS'));

    $data = curl_exec($curl);
    $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if (!$data || $status_code >= 400) {
        return [];
    }

    return $data;
});


Route::get('ajax/home', 'HomeController@ajaxHome');
Route::get('ajax/sidebar', 'HomeController@ajaxSidebar');
Route::get('ajax/followPodcast/{feedId}', 'HomeController@ajaxFollowPodcast');
Route::get('ajax/unfollowPodcast/{feedId}', 'HomeController@ajaxUnfollowPodcast');
Route::get('ajax/followUser/{username}', 'ProfileController@ajaxFollowUser');
Route::get('ajax/unfollowUser/{username}', 'ProfileController@ajaxUnfollowUser');
Route::get('ajax/allFriends', 'FriendsController@all');
Route::get('ajax/findUser/{user}', 'FriendsController@find');
Route::get('ajax/touchUser', 'HomeController@ajaxTouchUser');
Route::get('ajax/uptEpisode/{episodeId}/{currentTime}', 'HomeController@ajaxUptEpisode');

/* Podcast Router */
Route::get('podcast/{podcastId}', 'PodcastController@podcast');
Route::get('ajax/moreEpisodes/{podcastId}/{page?}', 'PodcastController@getEpisodesPerPage');
Route::get('discover', 'PodcastController@discover');
Route::get('ajax/homeNoFeeds', 'PodcastController@getHomeWithoutFeeds');
