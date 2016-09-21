<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    const API_ROOT_URL = 'http://brnapi.us-east-1.elasticbeanstalk.com/v1/';
    //const API_ROOT_URL = 'localhost:8081/v1/';

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
        if (Auth::guest()) {
            return view('home');
        }

        return view('home');
    }

    public function podcast($podcastId)
    {
        $podcast = $this->getPodcastById($podcastId);
        $episodes = $this->getEpisodes($podcastId);

        if (!$podcast) {
            return redirect('/404');
        }

        return view('podcast')->with('data', [
            'podcast' => reset($podcast),
            'episodes' => $episodes ? $this->formatEpisodes($episodes) : [],
            'userFollows' => $this->getUserListensToPodcast($podcastId)
        ]);
    }

    private function getLatestsPodcasts()
    {
        return $this->formatPodcasts(
            $this->getContentFrom(self::API_ROOT_URL . 'feeds/latest?limit=12')
        );
    }

    private function getLatestsEpisodes()
    {
        return $this->formatLatestsEpisodes(
            $this->getContentFrom(self::API_ROOT_URL . 'episodes/latest?limit=12')
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
        $data = $this->getContentFrom(self::API_ROOT_URL . "episodes/feed/$feedId?limit=8");
        return is_null($data) ? [] : $data;
    }

    public function getUserListensToPodcast($feedId)
    {
        $url = self::API_ROOT_URL . 'users/'.Auth::user()->name.'/feeds/'.$feedId;

        return $this->getContentFrom($url) ? true : false;
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
                'podcast_id' => $this->getLinkHash($episode['feed_id']),
                'podcast_name' => $episode['feed_name'],
                'title' => strip_tags($episode['episode_title']),
                'thumbnail' => $episode['feed_thumbnail'],
                'paused_at' => $episode['paused_at'],
                'media_url' => $episode['media_url'],
                'media_type' => $episode['media_type'],
                'published_date' => $this->formatData($episode['published_date']),
                'content' => $episode['content'],
            ];
        }, $episodes);
    }

    private function getContentFrom($source)
    {
        $curl = curl_init($source);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, 'brnbp' . ":" . 'brnbp');

        $data = curl_exec($curl);
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (!$data || $status_code >= 400) {
            return [];
        }

        return json_decode($data, true)['data'];
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

    public function ajaxHome()
    {
        $data = $this->getContentFrom(self::API_ROOT_URL . 'users/' . Auth::user()->name . '/feeds');

        return array_map(function($feed){
            return [
                "id" => $this->getLinkHash($feed['id']),
                "name" => $this->formatPodcastName($feed['name']),
                "thumbnail_30" => $feed['thumbnail_30'],
                "thumbnail_600" => $feed['thumbnail_600'],
                "total_episodes" => $feed['total_episodes'],
                "listen_all" => $feed['listen_all'],
                "last_episode_at" => $this->formatData($feed['last_episode_at'])
            ];
        }, $data);
    }

    public function ajaxHomeNoFeeds()
    {
        return $this->getLatestsPodcasts();
    }

    public function ajaxSidebar()
    {
        return $this->getContentFrom(self::API_ROOT_URL . 'users/' . Auth::user()->name);
    }

    public function ajaxFollowPodcast($feedId)
    {
        $url = self::API_ROOT_URL . 'users/' . Auth::user()->name . '/feeds/' . $feedId;

        return $this->makeCurl($url);
    }

    public function ajaxUnfollowPodcast($feedId)
    {
        $url = self::API_ROOT_URL . 'users/' . Auth::user()->name . '/feeds/' . $feedId;

        return $this->makeCurl($url, 'DELETE');
    }

    private function makeCurl($url, $method = 'POST')
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => array(
                "authorization: Basic YnJuYnA6YnJuYnA="
            ),
        ));

        curl_exec($curl);
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);


        if ($status_code >= 400) {
            return response('', 400);
        }

        return response('', 200);
    }
}
