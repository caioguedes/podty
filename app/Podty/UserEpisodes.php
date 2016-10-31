<?php
namespace App\Podty;

class UserEpisodes
{
    private $api;

    public function __construct(ApiClient $apiClient)
    {
        $this->api = $apiClient;
    }

    public function touch($username, $episodeId, $currentTime)
    {
        $this->api->put('users/' . $username . '/episodes/' . $episodeId . '/paused/' . $currentTime);
    }

    public function latests($username, $offset = 0, $limit = 50)
    {
        $url = 'users/' . $username . '/episodes/latests?limit=' . $limit . '&offset=' . $offset;
        return $this->api->get($url);
    }

    public function episodes($username, $podcastId)
    {
        return $this->api->get('users/' . $username . 'feeds/' . $podcastId . '/episodes');
    }

    public function detach($username, $episodeId)
    {
        return $this->api->delete('users/' . $username . '/episodes/' . $episodeId);
    }

    public function detachAll($username, $podcastId)
    {
        return $this->api->put('users/' . $username . '/feeds/' . $podcastId . '/listenAll');
    }
}
