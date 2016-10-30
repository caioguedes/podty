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
            return $this->formatHomePodcasts($feed);
        });

        return [
            'content' => $content,
            'type' => 'feeds'
        ];
    }
}
