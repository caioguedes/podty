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
}
