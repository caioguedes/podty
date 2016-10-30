<?php
namespace App\Http\Controllers;

use App\Format;
use App\Podty\ApiClient;
use App\Podty\UserPodcasts;
use App\Podty\Users;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use Format;

    private $apiClient;

    private $userPodcasts;

    private $users;

    public function __construct(ApiClient $apiClient, UserPodcasts $userPodcasts, Users $users)
    {
        $this->apiClient = $apiClient;
        $this->userPodcasts = $userPodcasts;
        $this->users = $users;
    }

    public function index($user = null)
    {
        $user = $this->getUser($user);

        if (!$user) {
            return redirect('/404');
        }

        return view('profile')->with('data', [
            'user' => $user,
            'podcasts' => $this->getUserPodcasts($user['username']),
            'isFriend' => !Auth::user() ? false : $this->getAreFriends($user)->count()
        ]);
    }

    private function getUser($user = null)
    {
        if (!$user && !Auth::user()) return false;

        return $this->users->get($user ?? Auth::user()->name)['data'];
    }

    public function getAreFriends($user)
    {
        $response = $this->users->friends(Auth::user()->name);

        return $response->filter(function($friend) use ($user) {
            if ($friend['username'] == $user['username']) {
                return true;
            }
           return false;
        });
    }

    public function getUserPodcasts($username)
    {
        $response = $this->userPodcasts->all($username);

        return $response->map(function($feed){
            return [
                "id" => $feed['id'],
                "name" => $this->formatPodcastName($feed['name']),
                "thumbnail_30" => $feed['thumbnail_30'],
                "thumbnail_600" => $feed['thumbnail_600'],
                "total_episodes" => $feed['total_episodes'],
                "listen_all" => $feed['listen_all'],
                "last_episode_at" => $this->formatData($feed['last_episode_at'])
            ];
        });
    }

    public function ajaxFollowUser($username)
    {
        if ($this->apiClient->post('users/' . Auth::user()->name . '/friends/' . $username)) {
            return response('', 200);
        }

        return response('', 400);
    }

    public function ajaxUnfollowUser($username)
    {
        if ($this->apiClient->delete('users/' . Auth::user()->name . '/friends/' . $username)) {
            return response('', 200);
        }

        return response('', 400);
    }
}
