<?php
namespace App\Podty;

use Illuminate\Support\Collection;

class UserEpisodes
{
    private $api;

    public function __construct()
    {
        $this->api = new ApiClient;
    }

    public function touch(string $username, int $episodeId, int $currentTime): bool
    {
        return $this->api->put('users/' . $username . '/episodes/' . $episodeId . '/paused/' . $currentTime);
    }

    public function latests(string $username, int $offset = 0, int $limit = 50): Collection
    {
        $url = 'users/' . $username . '/episodes/latests?limit=' . $limit . '&offset=' . $offset;
        return $this->returnDefaultResponse($this->api->get($url));
    }

    public function one(string $username, int $episodeId)
    {
        return $this->returnDefaultResponse(
            $this->api->get('users/' . $username . '/episodes/' . $episodeId)
        );
    }

    public function episodes(string $username, int $podcastId): array
    {
        return $this->api->get('users/' . $username . 'feeds/' . $podcastId . '/episodes');
    }

    public function detach(string $username, int $episodeId): bool
    {
        return $this->api->delete('users/' . $username . '/episodes/' . $episodeId);
    }

    public function detachAll(string $username, int $podcastId): bool
    {
        return $this->api->put('users/' . $username . '/feeds/' . $podcastId . '/listenAll');
    }

    private function returnDefaultResponse($response): Collection
    {
        return $response ? collect($response['data']) : collect([]);
    }
}
