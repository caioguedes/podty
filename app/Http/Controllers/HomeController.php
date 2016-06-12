<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    const API_ROOT_URL = 'brnpodapi-env.us-east-1.elasticbeanstalk.com/v1/';

    /**
     * Create a new controller instance.
     */
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
        $feeds = $this->getLatestsFeeds();

        return view('home')->with('data', [
            'feeds' => empty($feeds) ? [] : array_chunk($feeds, 4)[0],
            'episodes' => $this->formatEpisodesTitle($this->getLatestsEpisodes())
        ]);
    }

    public function podcast($feedId)
    {
        $feed = $this->getFeedById($feedId);
        $episodes = $this->getEpisodes($feedId);

        return view('podcast')->with('data', [
            'feed' => $feed ?: [],
            'episodes' => $episodes ?: []
        ]);
    }


    private function getLatestsFeeds()
    {
        return $this->getContentFrom(self::API_ROOT_URL . 'feeds/latest?limit=1');
    }

    private function getLatestsEpisodes()
    {
        return $this->formatLatestsEpisodes(
            $this->getContentFrom(self::API_ROOT_URL . 'episodes/latest')
        );
    }

    private function getFeed($name)
    {
        $data = $this->getContentFrom(self::API_ROOT_URL . "feeds/name/$name");
        return reset($data);
    }

    private function getFeedById($id)
    {
        $data = $this->getContentFrom(self::API_ROOT_URL . "feeds/id/$id");
        return reset($data);
    }

    private function getEpisodes($feedId)
    {
        return $this->getContentFrom(self::API_ROOT_URL . "episodes/feedId/$feedId");
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
            $episodeTitle =  $podcastTitle . ': ' . $episodeTitle;
        }

        return $episodeTitle;
    }

    private function formatLatestsEpisodes($episodes)
    {
        return array_map(function($episode){
            return [
                'id' => $episode['id'],
                'podcast_id' => $episode['feed_id'],
                'podcast_name' => $episode['name'],
                'title' => $episode['title'],
                'published_date' => $episode['published_date'],
                'content' => $episode['content'],
                'media_url' => $episode['media_url'],
                'media_type' => $episode['media_type'],
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
}
