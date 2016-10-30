<?php

namespace App\Http\Controllers;

use App\Format;
use App\Podty\Podcasts;
use App\Podty\UserPodcasts;
use Illuminate\Support\Facades\Auth;

class PodcastController extends Controller
{
    use Format;
    
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

    public function discover()
    {
        return view('top');
    }

    private function getUserFollowPodcast($feedId)
    {
        return $this->userPodcasts->follows(Auth::user()->name, $feedId);
    }
}
