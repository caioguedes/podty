<?php
namespace App\Http\Controllers;

use App\Format;
use App\Http\Requests;
use App\Podty\UserPodcasts;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    use Format;

    private $userPodcasts;

    public function __construct(UserPodcasts $userPodcasts)
    {
        $this->userPodcasts = $userPodcasts;
    }

    public function index()
    {
        return view('home');
    }

    public function ajaxHome()
    {
        if (!Auth::user() || Auth::user()->podcasts_count < 1) {
            return redirect('ajax/homeNoFeeds');
        }

        $response = $this->userPodcasts->all(Auth::user()->name);

        $content = $response->map(function($feed){
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

        return [
            'content' => $content,
            'type' => 'feeds'
        ];
    }
}
