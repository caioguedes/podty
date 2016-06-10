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
            'episodes' => $this->getLatestsEpisodes()
        ]);
    }

    public function podcast($feedId)
    {
        $feed = $this->getFeedById($feedId);
        $episodes = $this->getEpisodes($feedId);

        return view('welcome')->with('data', [
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
        return $this->getContentFrom(self::API_ROOT_URL . 'episodes/latest');
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

    private function getContentFrom($source)
    {
        $curl = curl_init($source);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $data = curl_exec($curl);

        return $data ? json_decode($data, true) : [];
    }
}
