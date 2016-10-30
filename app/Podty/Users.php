<?php
namespace App\Podty;

class Users
{
    private $api;

    public function __construct(ApiClient $apiClient)
    {
        $this->api = $apiClient;
    }

    public function get($username)
    {
        return $this->api->get('users/' . $username);
    }

    public function touch($username)
    {
        return $this->api->patch('users/' . $username . '/touch');
    }

    public function friends($username)
    {
        return $this->returnDefaultResponse(
            $this->api->get('users/' . $username . '/friends')
        );
    }

    private function returnDefaultResponse($response)
    {
        return $response ? collect($response['data']) : collect([]);
    }
}
