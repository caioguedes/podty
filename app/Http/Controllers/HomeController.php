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
        return view('home');
    }

    public function ajaxHome()
    {
        if (!Auth::user() || Auth::user()->podcasts_count < 1) {
            return response()->json([
                'content' => $this->formatPodcasts($this->podcastsApi->top()),
                'type' => 'no-feeds'
            ]);
        }

        $response = $this->userPodcasts->all(Auth::user()->name);

        $content = $response->map(function($feed){
            return $this->formatHomePodcasts($feed);
        });

        return [
            'content' => $content,
            'type' => 'feeds'
        ];
    }
}
