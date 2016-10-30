<?php
namespace App\Http\Controllers;

use App\Format;
use App\Http\Requests;
use App\Podty\Podcasts;
use App\Podty\UserPodcasts;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    use Format;

    private $userPodcasts;

    private $podcastsApi;

    public function __construct(UserPodcasts $userPodcasts, Podcasts $podcastsApi)
    {
        $this->userPodcasts = $userPodcasts;
        $this->podcastsApi = $podcastsApi;
    }

    public function index()
    {
        if (!Auth::user() || Auth::user()->podcasts_count < 1) {
            return view('home')->with([
                'content' => $this->formatPodcasts($this->podcastsApi->top()),
                'title' => 'Top Podcasts'
            ]);
        }

        $response = $this->userPodcasts->all(Auth::user()->name);

        $content = $response->map(function($feed){
            return $this->formatHomePodcasts($feed);
        });

        return view('home')->with([
            'content' => $content,
            'title' => 'Your Library'
        ]);
    }
}
