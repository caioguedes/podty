<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use DateTime;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    const API_ROOT_URL = 'brnpodapi-env.us-east-1.elasticbeanstalk.com/v1/';
    //const API_ROOT_URL = 'localhost:8080/v1/';

    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $podcasts = $this->getLatestsPodcasts();

        return view('home')->with('data', [
            'podcasts' => empty($podcasts) ? [] : array_chunk($podcasts, 4)[0],
            'episodes' => $this->formatEpisodesTitle($this->getLatestsEpisodes())
        ]);
    }

    public function podcast($podcastId)
    {
        $podcast = $this->getPodcastById($podcastId);
        $episodes = $this->getEpisodes($podcastId);

        if (!$podcast) {
            return view('errors.404');
        }

        return view('podcast')->with('data', [
            'podcast' => reset($podcast),
            'episodes' => $episodes ? $this->formatEpisodes($episodes) : []
        ]);
    }

    private function getLatestsPodcasts()
    {
        return $this->formatPodcasts(
            $this->getContentFrom(self::API_ROOT_URL . 'feeds/latest?limit=1')
        );
    }

    private function getLatestsEpisodes()
    {
        return $this->formatLatestsEpisodes(
            $this->getContentFrom(self::API_ROOT_URL . 'episodes/latest')
        );
    }

    private function getPodcastById($id)
    {
        $data = $this->getContentFrom(self::API_ROOT_URL . "feeds/id/$id");

        if(is_null($data)) {
            return [];
        }

        return $this->formatPodcasts($data);
    }

    private function getEpisodes($feedId)
    {
        $data = $this->getContentFrom(self::API_ROOT_URL . "episodes/feedId/$feedId?limit=8");
        return is_null($data) ? [] : $data;
    }

    private function formatPodcasts($feeds)
    {
        return array_map(function($feed){
            return [
                "id" => $this->getLinkHash($feed['id']),
                "name" => $this->formatPodcastName($feed['name']),
                "url" => $feed['url'],
                "thumbnail_30" => $feed['thumbnail_30'],
                "thumbnail_60" => $feed['thumbnail_60'],
                "thumbnail_100" => $feed['thumbnail_100'],
                "thumbnail_600" => $feed['thumbnail_600'],
                "total_episodes" => $feed['total_episodes'],
                "last_episode_at" => $this->formatData($feed['last_episode_at'])
            ];
        }, $feeds);
    }

    private function formatEpisodesTitle($episodes)
    {
        return array_map(function($episode){
            $episode['title'] = $this->formatEpisodeTitle($episode['title'], $episode['podcast_name']);
            return $episode;
        }, $episodes);
    }

    private function formatEpisodeTitle($episodeTitle, $podcastTitle)
    {
        $episodeTitle = substr($episodeTitle, 0, 60);
        if (strlen($episodeTitle) < 25) {
            $episodeTitle =  $this->formatPodcastName($podcastTitle) . ': ' . $episodeTitle;
        }

        return $episodeTitle;
    }

    private function formatEpisodes($episodes)
    {
        return array_map(function($episode){
            return [
                'id' => $episode['id'],
                'podcast_id' => $this->getLinkHash($episode['feed_id']),
                'title' => strip_tags($episode['title']),
                'link' => $episode['link'],
                'published_date' => $this->formatData($episode['published_date']),
                'content' => strip_tags($episode['content']),
                'media_url' => $episode['media_url'],
                'media_type' => $episode['media_type'],
            ];
        }, $episodes);
    }

    private function formatLatestsEpisodes($episodes)
    {
        return array_map(function($episode){
            return [
                'id' => $episode['id'],
                'podcast_id' => $this->getLinkHash($episode['feed_id']),
                'podcast_name' => $episode['name'],
                'title' => strip_tags($episode['title']),
                'thumbnail_30' => $episode['thumbnail_30'],
                'thumbnail_60' => $episode['thumbnail_60'],
            ];
        }, $episodes);
    }

    private function getContentFrom($source)
    {
        $curl = curl_init($source);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $data = curl_exec($curl);

        return $data ? json_decode($data, true) : [];
    }

    private function getLinkHash($id)
    {
        return  $id . 'p'. rand(15345,94334);
    }

    private function formatData($date)
    {
        return (new DateTime($date))->format('d/m/Y H:i');
    }

    private function formatPodcastName($podcastName)
    {
        $separators = ['-', '/', '|'];
        return explode('-', str_replace($separators, '-', $podcastName))[0];
    }
}
