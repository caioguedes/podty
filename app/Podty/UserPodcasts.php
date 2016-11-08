<?php
namespace App\Podty;


use Illuminate\Support\Collection;

class UserPodcasts
{
    private $api;

    public function __construct(ApiClient $apiClient)
    {
        $this->api = $apiClient;
    }

    public function all(string $username): Collection
    {
        return $this->returnDefaultResponse(
            $this->api->get('users/' . $username . '/feeds')
        );
    }

    public function one(string $username, int $podcastId): Collection
    {
        return $this->returnDefaultResponse(
            $this->api->get('users/' . $username . '/feeds' . $podcastId)
        );
    }

    public function follows(string $username, int $podcastID): bool
    {
        $response = $this->api->get('users/' . $username . '/feeds/' . $podcastID);

        return !empty($response['data']);
    }

    public function follow(string $username, int $podcastId): bool
    {
        return $this->api->post('users/' . $username . '/feeds/' . $podcastId);
    }

    public function unfollow(string $username, int $podcastId): bool
    {
        return $this->api->delete('users/' . $username . '/feeds/' . $podcastId);
    }

    private function returnDefaultResponse($response): Collection
    {
        return $response ? collect($response['data']) : collect([]);
    }
}
