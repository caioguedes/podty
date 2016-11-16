<?php
namespace App\Podty;

use Illuminate\Support\Collection;

class Podcasts
{
    private $api;

    public function __construct()
    {
        $this->api = new ApiClient;
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

    public function episode(int $episodeId)
    {
        $url = 'episodes/' . $episodeId;

        return $this->returnDefaultResponse($this->api->get($url));
    }

    public function episodes(int $podcastId, int $offset = 0, int $limit = 28): Collection
    {
        $url = 'feeds/' . $podcastId . '/episodes?limit=' . $limit;

        if ($offset) {
            $url .= '&offset=' . $offset;
        }

        return $this->returnDefaultResponse($this->api->get($url));
    }

    public function findByName($name)
    {
        return $this->api->get('feeds/name/' . rawurlencode($name));
    }

    public function findOnEpisodes($podcastId, $searchFor)
    {
        return $this->api->get('feeds/'. $podcastId . '/episodes?term=' . $searchFor);
    }

    private function returnDefaultResponse($response): Collection
    {
        return $response ? collect($response['data']) : collect([]);
    }
}
