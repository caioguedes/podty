<?php
namespace App\Podty;

class Podcasts
{
    private $api;

    public function __construct(ApiClient $apiClient)
    {
        $this->api = $apiClient;
    }

    public function one($id)
    {
        return $this->returnDefaultResponse(
            $this->api->get('feeds/' . $id)
        );
    }

    public function top($quantity = 24)
    {
        return $this->returnDefaultResponse(
            $this->api->get('feeds/top/' . $quantity)
        );
    }

    public function episodes($podcastId, $offset = 0, $limit = 28)
    {
        $url = 'feeds/' . $podcastId . '/episodes?limit=' . $limit;

        if ($offset) {
            $url .= '&offset=' . $offset;
        }

        return $this->returnDefaultResponse($this->api->get($url));
    }

    private function returnDefaultResponse($response)
    {
        return $response ? collect($response['data']) : collect([]);
    }
}
