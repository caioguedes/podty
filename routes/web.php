<?php

Auth::routes();
Route::get('/', 'HomeController@index');
Route::get('profile/{user?}', 'ProfileController@index');
Route::get('feed/{searchInput}', 'PodcastController@findByName');

Route::get('episode/{podcastId}/{term}', 'PodcastController@findOnEpisodes');

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


Route::get('ajax/myPods', function (\App\Podty\UserPodcasts $userPodcasts){
   return $userPodcasts->all(Auth::user()->name);
});
