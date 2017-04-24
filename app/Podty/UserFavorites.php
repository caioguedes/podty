<?php
namespace App\Podty;

use Illuminate\Support\Facades\Cache;

class UserFavorites
{
    private $api;

    public function __construct()
    {
        $this->api = new ApiClient;
    }

    public function all(string $username)
    {
        return Cache::remember('users_favorites_' . $username, 360, function() use ($username) {
            return $this->api->get('users/' . $username . '/episodes/favorites');
        });
    }

    public function create(string $username, int $episodeId): bool
    {
        Cache::forget('users_favorites_' . $username);
        return $this->api->post('users/' . $username . '/episodes/' . $episodeId . '/favorite');
    }

    public function delete(string $username, int $episodeId): bool
    {
        Cache::forget('users_favorites_' . $username);
        return $this->api->delete('users/' . $username . '/episodes/' . $episodeId . '/favorite');
    }
}
