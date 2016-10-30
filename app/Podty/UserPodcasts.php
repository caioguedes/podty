<?php
namespace App\Podty;


class UserPodcasts
{
    private $api;

    public function __construct(ApiClient $apiClient)
    {
        $this->api = $apiClient;
    }

    public function all($username)
    {
        return $this->returnDefaultResponse(
            $this->api->get('users/' . $username . '/feeds')
        );
    }

    public function one($username, $podcastId)
    {
        return $this->returnDefaultResponse(
            $this->api->get('users/' . $username . '/feeds' . $podcastId)
        );
    }

    private function returnDefaultResponse($response)
    {
        return $response ? collect($response['data']) : collect([]);
    }
}
