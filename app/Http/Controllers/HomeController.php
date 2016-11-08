<?php
namespace App\Http\Controllers;

use App\Format;
use App\Http\Requests;
use App\Podty\ApiClient;
use App\Podty\Podcasts;
use App\Podty\UserEpisodes;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    use Format;

    private $podcastsApi;

    public function __construct(Podcasts $podcastsApi)
    {
        $this->podcastsApi = $podcastsApi;
    }

    public function index()
    {
        if (!Auth::user() || Auth::user()->podcasts_count < 1) {
            return redirect('/discover');
        }

        $episodes = (new UserEpisodes(new ApiClient))->latests(Auth::user()->name, 0, 100);
        $episodes = $this->formatEpisodes(collect($episodes['data']));

        return view('home')->with([
            'episodes' => $episodes,
            'title' => 'Latests Episodes'
        ]);
    }

    public function discover()
    {
        return view('discover')->with([
            'content' => $this->podcastsApi->top(),
            'title' => 'Discover'
        ]);
    }
}
