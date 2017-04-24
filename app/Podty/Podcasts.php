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
        $podcasts = Cache::remember('podcasts_top', 360, function() use ($quantity) {
            return $this->api->get('feeds/top/' . $quantity);
        });

        return $this->returnDefaultResponse($podcasts);
    }

    public function episode(int $episodeId)
    {
        $response = Cache::remember('episodes_' . $episodeId, 1000, function() use ($episodeId) {
            return $this->api->get('episodes/' . $episodeId);
        });

        return $this->returnDefaultResponse($response);
    }

    public function episodes(int $podcastId, int $offset = 0, int $limit = 28): Collection
    {
        $url = 'feeds/' . $podcastId . '/episodes?limit=' . $limit;

        if ($offset) {
            $url .= '&offset=' . $offset;
        }

        $hash = md5($podcastId . 'episodes' . $offset . $limit);
        $episodes = Cache::remember($hash, 60, function() use ($url) {
            dd('hit');
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
