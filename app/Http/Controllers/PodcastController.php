<?php

namespace App\Http\Controllers;

use App\Http\ApiClient;
use Illuminate\Support\Facades\Auth;

class PodcastController extends Controller
{
    /**
     * @var ApiClient
     */
    private $api;

    /**
     * PodcastController constructor.
     * @param ApiClient $api
     */
    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    /**
     * Get Top Rated Podcasts
     * @return array
     */
    public function getTopPodcasts()
    {
        $podcasts = $this->api->get('feeds/top/24');

        return $this->formatPodcasts(
            $podcasts['data'] ?? []
        );
    }

    /**
     * @param $feedId
     * @return bool
     */
    public function getUserFollowPodcast($feedId)
    {
        $user = Auth::user();

        $response = $this->api
            ->get('users/' . $user->name . '/feeds/' . $feedId);

        return !empty($response['data']);
    }

    /**
     * @param $id
     * @return array
     */
    private function getPodcastById($id)
    {
        $podcast = $this->api->get("feeds/{$id}");

        return $this->formatPodcasts(
            $podcast['data'] ?? []
        );
    }

    /**
     * @param $podcastId
     * @return mixed
     */
    public function podcast($podcastId)
    {
        $podcast = $this->getPodcastById($podcastId);

        $userFollows = Auth::user() ? $this->getUserFollowPodcast($podcastId) : false;

        $episodes = $this->getEpisodes($podcastId);

        if (!$podcast) {
            return redirect('/404');
        }

        return view('podcast')->with('data', [
            'podcast'     => reset($podcast),
            'episodes'    => $episodes ? $this->formatEpisodes($episodes) : [],
            'userFollows' => $userFollows
        ]);
    }

    /**
     * @param $podcastId
     * @param int $page
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function getEpisodesPerPage($podcastId, $page = 1)
    {
        $limit = 28;
        $offset = ($limit * $page);

        $episodes = $this->getEpisodes($podcastId, $offset);

        if (!$episodes) {
            return response()->json([], 404);
        }

        return response()->json( [
            'podcast'  => array_first($this->getPodcastById($podcastId)),
            'episodes' => $this->formatEpisodes($episodes),
        ]);
    }

    /**
     * @param array $episodes
     * @return array
     */
    private function formatEpisodes($episodes)
    {
        return array_map(function ($episode) {

            $episode = (object) $episode;

            return [
                'id'             => $episode->id,
                'podcast_id'     => $episode->feed_id,
                'title'          => strip_tags($episode->title),
                'link'           => $episode->link,
                'published_date' => $this->formatData($episode->published_date),
                'content'        => $episode->content,
                'summary'        => $episode->summary ?? '',
                'image'          => $episode->image,
                'duration'       => $episode->duration,
                'media_url'      => $episode->media_url,
                'media_type'     => $episode->media_type,
            ];

        }, $episodes);
    }

    /**
     * @param string $date
     * @return string
     */
    private function formatData($date)
    {
        return (new \DateTime($date))->format('d/m/Y H:i');
    }

    /**
     * @param string $podcastName
     * @return mixed
     */
    private function formatPodcastName($podcastName)
    {
        $separators = ['-', '/', '|'];
        return explode('-', str_replace($separators, '-', $podcastName))[0];
    }

    /**
     * @param array $feeds
     * @return array
     */
    private function formatPodcasts($feeds = [])
    {
        return array_map(function ($feed) {

            $feed = (object) $feed;

            return [
                "id"              => $feed->id,
                "name"            => $this->formatPodcastName($feed->name),
                "url"             => $feed->url,
                "thumbnail_30"    => $feed->thumbnail_30,
                "thumbnail_60"    => $feed->thumbnail_60,
                "thumbnail_100"   => $feed->thumbnail_100,
                "thumbnail_600"   => $feed->thumbnail_600,
                "total_episodes"  => $feed->total_episodes,
                "listeners"       => $feed->listeners,
                "last_episode_at" => $this->formatData($feed->last_episode_at)
            ];

        }, $feeds);
    }

    /**
     * @param $feedId
     * @param int $offset
     * @param int $limit
     * @return array
     */
    private function getEpisodes($feedId, $offset = 0, $limit = 28)
    {
        $url = "feeds/$feedId/episodes?limit=" . $limit;

        if ($offset) {
            $url .= '&offset=' . $offset;
        }

        $response = $this->api->get($url);

        return ($response['data'] ?? []);
    }

    public function discover()
    {
        return view('top');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDiscoverWithoutFeeds()
    {
        return response()->json([
            'content' => $this->getTopPodcasts(),
            'type' => 'no-feeds'
        ]);
    }
}
