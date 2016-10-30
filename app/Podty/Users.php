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
}
