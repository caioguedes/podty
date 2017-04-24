<?php
namespace App\Podty;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class UserPodcasts
{
    private $api;

    public function __construct()
    {
        $this->api = new ApiClient;
    }

    public function all(string $username): Collection
    {
        $response = Cache::remember('user_podcasts_' . $username, 60, function() use ($username) {
            return $this->api->get('users/' . $username . '/feeds');
        });

        return $this->returnDefaultResponse($response);
    }

    public function one(string $username, int $podcastId): Collection
    {
        return $this->returnDefaultResponse(
            $this->api->get('users/' . $username . '/feeds/' . $podcastId)
        );
    }

    public function follows(string $username, int $podcastID): bool
    {
        $response = $this->api->get('users/' . $username . '/feeds/' . $podcastID);

        return !empty($response['data']);
    }

    public function follow(string $username, int $podcastId): bool
    {
        Cache::forget('user_podcasts_' . $username);
        return $this->api->post('users/' . $username . '/feeds/' . $podcastId);
    }

    public function unfollow(string $username, int $podcastId): bool
    {
        Cache::forget('user_podcasts_' . $username);
        return $this->api->delete('users/' . $username . '/feeds/' . $podcastId);
    }

    private function returnDefaultResponse($response): Collection
    {
        return $response ? collect($response['data']) : collect([]);
    }
}
