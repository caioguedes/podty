<?php
namespace App\Podty;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class Users
{
    private $api;

    public function __construct()
    {
        $this->api = new ApiClient;
    }

    public function get(string $username): array
    {
        return $this->api->get('users/' . $username);
    }

    public function touch(string $username): bool
    {
        return $this->api->patch('users/' . $username . '/touch');
    }

    public function friends(string $username): Collection
    {
        $response = Cache::remember('user_friends_' . $username, 200, function() use ($username) {
            return $this->api->get('users/' . $username . '/friends');
        });

        return $this->returnDefaultResponse($response);
    }

    public function follow(string $authUser, string $targetUser): bool
    {
        Cache::forget('user_friends_' . $authUser);
        return $this->api->post('users/' . $authUser . '/friends/' . $targetUser);
    }

    public function unfollow(string $authUser, string $targetUser): bool
    {
        Cache::forget('user_friends_' . $authUser);
        return $this->api->delete('users/' . $authUser . '/friends/' . $targetUser);
    }

    private function returnDefaultResponse($response): Collection
    {
        return $response ? collect($response['data']) : collect([]);
    }
}
