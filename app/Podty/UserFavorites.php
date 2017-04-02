<?php
namespace App\Podty;

class UserFavorites
{
    private $api;

    public function __construct()
    {
        $this->api = new ApiClient;
    }

    public function all(string $username)
    {
        return $this->api->get('users/' . $username . '/episodes/favorites');
    }

    public function create(string $username, int $episodeId): bool
    {
        return $this->api->post('users/' . $username . '/episodes/' . $episodeId . '/favorite');
    }

    public function delete(string $username, int $episodeId): bool
    {
        return $this->api->delete('users/' . $username . '/episodes/' . $episodeId . '/favorite');
    }
}
