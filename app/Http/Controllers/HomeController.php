<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function getUserListensToPodcast($feedId)
    {
        $url = env('API_BASE_URL') . 'users/'.Auth::user()->name.'/feeds/'.$feedId;

        return $this->getContentFrom($url) ? true : false;
    }

    private function getContentFrom($source)
    {
        $curl = curl_init($source);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, env('API_AUTH_USER') . ":" . env('API_AUTH_PASS'));

        $data = curl_exec($curl);
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (!$data || $status_code >= 400) {
            return [];
        }

        $response = json_decode($data, true);

        $this->meta = $response['meta'] ?? [];

        return $response['data'];
    }

    private function formatData($date)
    {
        return (new DateTime($date))->format('d/m/Y H:i');
    }

    public function ajaxHome()
    {
        if (!Auth::user() || Auth::user()->podcasts_count < 1) {
            return redirect()->route('podcast.discoverWithoutFeeds');
        }

        $data = $this->getContentFrom(env('API_BASE_URL') . 'users/' . Auth::user()->name . '/feeds');

        $content = array_map(function($feed){
            return [
                "id" => $feed['id'],
                "name" => $this->formatPodcastName($feed['name']),
                "thumbnail_30" => $feed['thumbnail_30'],
                "thumbnail_600" => $feed['thumbnail_600'],
                "total_episodes" => $feed['total_episodes'],
                "listen_all" => $feed['listen_all'],
                "last_episode_at" => $this->formatData($feed['last_episode_at'])
            ];
        }, $data);

        return [
            'content' => $content,
            'type' => 'feeds'
        ];
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

    public function ajaxSidebar()
    {
        return $this->getContentFrom(env('API_BASE_URL') . 'users/' . Auth::user()->name);
    }

    public function ajaxFollowPodcast($feedId)
    {
        $url = env('API_BASE_URL') . 'users/' . Auth::user()->name . '/feeds/' . $feedId;

        Auth::user()->podcasts_count++;

        Auth::user()->save();

        return $this->makeCurl($url);
    }

    public function ajaxUnfollowPodcast($feedId)
    {
        $url = env('API_BASE_URL') . 'users/' . Auth::user()->name . '/feeds/' . $feedId;

        Auth::user()->podcasts_count--;

        Auth::user()->save();

        return $this->makeCurl($url, 'DELETE');
    }

    public function ajaxTouchUser()
    {
        if (Auth::user()) {
            $this->makeCurl(env('API_BASE_URL') . 'users/' . Auth::user()->name . '/touch' , 'PATCH');
        }
    }

    public function ajaxUptEpisode($episodeId, $currentTime)
    {
        if (Auth::user())
            $this->makeCurl(env('API_BASE_URL') . 'users/' . Auth::user()->name . '/episodes/' . $episodeId . '/paused/' . $currentTime, 'PUT');
    }

    private function makeCurl($url, $method = 'POST')
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_USERPWD => env('API_AUTH_USER') . ":" . env('API_AUTH_PASS')
        ));

        curl_exec($curl);
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);


        if ($status_code >= 400) {
            return response('', 400);
        }

        return response('', 200);
    }
}
