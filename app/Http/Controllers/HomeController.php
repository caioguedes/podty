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
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    use Format;

    public function index()
    {
        if (!Auth::user() || Auth::user()->podcasts_count < 1) {
            return redirect('/discover');
        }

        $episodes = (new UserEpisodes(new ApiClient))->latests(Auth::user()->name, 0, 150);

        return view('home')->with([
            'episodes' => $episodes,
            'title' => 'Latests Episodes (' . $episodes->count() . ')'
        ]);
    }

    public function discover()
    {
        return view('discover')->with([
            'podcasts' => (new Podcasts)->top(),
            'title' => 'Discover'
        ]);
    }
}
