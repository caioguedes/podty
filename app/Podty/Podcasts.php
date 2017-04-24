<?php
namespace App\Podty;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

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

        $episodes = Cache::remember('podcast_' . $podcastId . '_episodes', 60, function() use ($url) {
            return $this->api->get($url);
        });

        return $this->returnDefaultResponse($episodes);
    }

    public function findByName($name)
    {
        return $this->api->get('feeds/name/' . rawurlencode($name));
    }

    public function findOnEpisodes($podcastId, $searchFor)
    {
        return $this->api->get('feeds/'. $podcastId . '/episodes?term=' . $searchFor);
    }

    public function listeners($podcastId)
    {
        $response = Cache::remember('podcast_' . $podcastId . '_listeners', 60, function() use ($podcastId) {
            return $this->api->get('feeds/' . $podcastId . '/listeners');
        });

        return $this->returnDefaultResponse($response);
    }

    private function returnDefaultResponse($response): Collection
    {
        return $response ? collect($response['data']) : collect([]);
    }
}
