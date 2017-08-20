<?php
namespace App\Http\Controllers;

use App\Events\AnalyticsPageView;
use App\Format;
use App\Podty\ApiClient;
use App\Podty\Podcasts;
use App\Podty\UserEpisodes;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    use Format;

    public function index()
    {
        if (!Auth::user()) {
            return view('home.guest');
        }
        
        if (!Auth::user()->podcasts_count) {
            return redirect('/discover');
        }
        
        event(new AnalyticsPageView('/home', 'BE - Latests Episodes'));
        $episodes = (new UserEpisodes(new ApiClient))
                        ->latests(Auth::user()->name, 0, 150);

        return view('home')->with([
            'episodes' => $episodes,
            'title' => 'Latests Episodes (' . $episodes->count() . ')'
        ]);
    }

    public function discover()
    {
        event(new AnalyticsPageView('/discover', 'BE - Discover'));

        return view('discover')->with([
            'podcasts' => (new Podcasts)->top(),
            'title' => 'Discover'
        ]);
    }
}
