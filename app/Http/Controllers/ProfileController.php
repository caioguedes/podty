<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index($user = null)
    {
        $user = $this->getUser($user);

        if (!$user) {
            return redirect('/404');
        }

        return view('profile')->with('data', [
            'user' => $user,
            'podcasts' => $this->getUserPodcasts($user['username']),
            'isFriend' => !Auth::user() ? false : empty($this->getAreFriends($user)) ? false : true
        ]);
    }

    private function getUser($user = null)
    {
        if (!$user && !Auth::user()) return false;

        return $this->getContentFrom(env('API_BASE_URL') . 'users/' . ($user ?? Auth::user()->name));
    }

    public function getAreFriends($user)
    {
        $url = env('API_BASE_URL') . 'users/'.Auth::user()->name.'/friends';

        $response = $this->getContentFrom($url);

        return array_filter($response, function($friend) use($user) {
            if ($friend['username'] == $user['username']) {
                return true;
            }
           return false;
        });
    }

    public function getUserPodcasts($username)
    {
        $data = $this->getContentFrom(env('API_BASE_URL') . 'users/' . $username . '/feeds');

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

        return json_decode($data, true)['data'];
    }

    private function formatPodcastName($podcastName)
    {
        $separators = ['-', '/', '|'];
        return explode('-', str_replace($separators, '-', $podcastName))[0];
    }

    private function getLinkHash($id)
    {
        return  $id . 'p'. rand(15345,94334);
    }

    private function formatData($date)
    {
        return (new \DateTime($date))->format('d/m/Y H:i');
    }


    public function ajaxFollowUser($username)
    {
        $url = env('API_BASE_URL') . 'users/' . Auth::user()->name . '/friends/' . $username;

        return $this->makeCurl($url);
    }

    public function ajaxUnfollowUser($username)
    {
        $url = env('API_BASE_URL') . 'users/' . Auth::user()->name . '/friends/' . $username;

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
