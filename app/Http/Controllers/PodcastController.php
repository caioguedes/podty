<?php

namespace App\Http\Controllers;

use App\Podty\ApiClient;
use App\Podty\Podcasts;
use App\Podty\UserPodcasts;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class PodcastController extends Controller
{
    private $podcastsApi;

    private $userPodcasts;

    public function __construct(Podcasts $podcastsApi, UserPodcasts $userPodcasts)
    {
        $this->podcastsApi = $podcastsApi;
        $this->userPodcasts = $userPodcasts;
    }

    /**
     * Get Top Rated Podcasts
     * @return array
     */
    public function top()
    {
        $podcasts = $this->podcastsApi->top();

        return $this->formatPodcasts($podcasts);
    }

    /**
     * @param $feedId
     * @return bool
     */
    public function getUserFollowPodcast($feedId)
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $this->userPodcasts->follows($user->name, $feedId);
    }

    /**
     * @param $id
     * @return array
     */
    private function getPodcastById($id)
    {
        return $this->formatPodcasts($this->podcastsApi->one($id));
    }

    /**
     * @param $podcastId
     * @return mixed
     */
    public function podcast($podcastId)
    {
        $podcast = $this->getPodcastById($podcastId);
        $podcast = reset($podcast);

        $userFollows = Auth::user() ? $this->getUserFollowPodcast($podcastId) : false;

        $episodes = $this->podcastsApi->episodes($podcastId);

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

        $episodes = $this->podcastsApi->episodes($podcastId, $offset);

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
        return $episodes->map(function($episode) {
            return [
                'id' => $episode['id'],
                'podcast_id' => $episode['feed_id'],
                'title' => strip_tags($episode['title']),
                'link' => $episode['link'],
                'published_date' => $this->formatData($episode['published_date']),
                'content' => $episode['content'],
                'summary' => $episode['summary'] ?? '',
                'image' => $episode['image'],
                'duration' => $episode['duration'],
                'media_url' => $episode['media_url'],
                'media_type' => $episode['media_type'],
            ];

        });
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

    private function formatPodcasts(Collection $podcasts)
    {
        return $podcasts->map(function($podcast) {
            return [
                "id" => $podcast['id'],
                "name" => $this->formatPodcastName($podcast['name']),
                "url" => $podcast['url'],
                "thumbnail_30" => $podcast['thumbnail_30'],
                "thumbnail_60" => $podcast['thumbnail_60'],
                "thumbnail_100" => $podcast['thumbnail_100'],
                "thumbnail_600" => $podcast['thumbnail_600'],
                "total_episodes" => $podcast['total_episodes'],
                "listeners" => $podcast['listeners'],
                "last_episode_at" => $this->formatData($podcast['last_episode_at'])
            ];
        });
    }

    public function discover()
    {
        return view('top');
    }

    public function getHomeNoFeeds()
    {
        return response()->json([
            'content' => $this->top(),
            'type' => 'no-feeds'
        ]);
    }
}
