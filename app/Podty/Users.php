<?php
namespace App\Podty;

use Illuminate\Support\Collection;

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
        return $this->returnDefaultResponse(
            $this->api->get('users/' . $username . '/friends')
        );
    }

    public function follow(string $authUser, string $targetUser): bool
    {
        return $this->api->post('users/' . $authUser . '/friends/' . $targetUser);
    }

    public function unfollow(string $authUser, string $targetUser): bool
    {
        return $this->api->delete('users/' . $authUser . '/friends/' . $targetUser);
    }

    private function returnDefaultResponse($response): Collection
    {
        return $response ? collect($response['data']) : collect([]);
    }
}
