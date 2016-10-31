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

Route::get('ajax/sidebar', 'UsersController@get');
Route::get('ajax/followPodcast/{feedId}', 'UserPodcastsController@follow');
Route::get('ajax/unfollowPodcast/{feedId}', 'UserPodcastsController@unfollow');
Route::get('ajax/followUser/{username}', 'ProfileController@follow');
Route::get('ajax/unfollowUser/{username}', 'ProfileController@unfollow');
Route::get('ajax/allFriends', 'FriendsController@all');
Route::get('ajax/findUser/{user}', 'FriendsController@find');
Route::get('ajax/touchUser', 'UsersController@touch');
Route::get('ajax/uptEpisode/{episodeId}/{currentTime}', 'UserEpisodesController@touch');

Route::get('ajax/detachEpisode/{episodeId}', 'UserEpisodesController@detach');

/* Podcast Router */
Route::get('podcast/{podcastId}', 'PodcastController@podcast');
Route::get('ajax/moreEpisodes/{podcastId}/{page?}', 'PodcastController@getEpisodesPerPage');
Route::get('discover', 'HomeController@discover');
Route::get('ajax/discover', 'PodcastController@top');

Route::get('podcasts', 'PodcastController@home');
