<?php
namespace App\Podty;

use Illuminate\Support\Collection;

class Podcasts
{
    private $api;

    public function __construct(ApiClient $apiClient)
    {
        $this->api = $apiClient;
    }

    public function one(int $id): Collection
    {
        return $this->returnDefaultResponse(
            $this->api->get('feeds/' . $id)
        );
    }

    public function top(int $quantity = 24): Collection
    {
        return $this->returnDefaultResponse(
            $this->api->get('feeds/top/' . $quantity)
        );
    }

    public function episodes(int $podcastId, int $offset = 0, int $limit = 28): Collection
    {
        $url = 'feeds/' . $podcastId . '/episodes?limit=' . $limit;

        if ($offset) {
            $url .= '&offset=' . $offset;
        }

        return $this->returnDefaultResponse($this->api->get($url));
    }

    private function returnDefaultResponse($response): Collection
    {
        return $response ? collect($response['data']) : collect([]);
    }
}
